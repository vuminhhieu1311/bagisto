<?php

namespace Webkul\CatalogRule\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Webkul\CatalogRule\Contracts\CatalogRule;
use Webkul\CatalogRule\Helpers\CatalogRuleIndex;
use Webkul\Product\Helpers\Indexers\Price as PriceIndexer;
use Webkul\Product\Repositories\ProductRepository;

class UpdateCreateCatalogRuleIndex implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Default batch size
     */
    protected const BATCH_SIZE = 100;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected CatalogRule $catalogRule) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->catalogRule->status) {
            app(CatalogRuleIndex::class)->reIndexRule($this->catalogRule);

            /**
             * Reindex price index for the products associated with the catalog rule.
             */
            $productIds = $this->catalogRule->catalog_rule_products->pluck('product_id')->unique();
        } else {
            $productIds = $this->catalogRule->catalog_rule_products->pluck('product_id')->unique();

            app(CatalogRuleIndex::class)->cleanProductIndices($productIds);
        }

        while (true) {
            $paginator = app(ProductRepository::class)
                ->whereIn('id', $productIds)
                ->cursorPaginate(self::BATCH_SIZE);

            /**
             * TODO:
             *
             * If the catalog rule is disabled and 'end_other_rules' flag is set,
             * it indicates that this rule might have preempted the
             * application of other rules on the products. In such a scenario,
             * it's necessary to reindex the remaining rules for these products.
             */
            app(PriceIndexer::class)->reindexBatch($paginator->items());

            if (! $cursor = $paginator->nextCursor()) {
                break;
            }

            request()->query->add(['cursor' => $cursor->encode()]);
        }

        if (filter_var(env('CATALOG_RULE_DEBUG', true), FILTER_VALIDATE_BOOL)) {
            $today = Carbon::now()->format('Y-m-d');

            $matchedRows = DB::table('catalog_rule_products')
                ->where('catalog_rule_id', $this->catalogRule->id)
                ->count();

            $priceRowsToday = DB::table('catalog_rule_product_prices')
                ->where('catalog_rule_id', $this->catalogRule->id)
                ->where('rule_date', $today)
                ->count();

            $channels = method_exists($this->catalogRule, 'channels') ? $this->catalogRule->channels : null;
            $customerGroups = method_exists($this->catalogRule, 'customer_groups') ? $this->catalogRule->customer_groups : null;

            logger()->info('catalog_rule.index.debug', [
                'catalog_rule_id'        => $this->catalogRule->id,
                'name'                  => $this->catalogRule->name ?? null,
                'status'                => (int) $this->catalogRule->status,
                'starts_from'           => $this->catalogRule->starts_from,
                'ends_till'             => $this->catalogRule->ends_till,
                'condition_type'        => $this->catalogRule->condition_type ?? null,
                'action_type'           => $this->catalogRule->action_type ?? null,
                'discount_amount'       => $this->catalogRule->discount_amount ?? null,
                'end_other_rules'       => (int) ($this->catalogRule->end_other_rules ?? 0),
                'channels'              => $channels,
                'customer_groups'       => $customerGroups,
                'matched_rows_total'    => $matchedRows,
                'price_rows_today'      => $priceRowsToday,
                'price_rule_date'       => $today,
                'reindexed_product_ids' => $productIds instanceof \Illuminate\Support\Collection ? $productIds->count() : count((array) $productIds),
            ]);
        }
    }
}
