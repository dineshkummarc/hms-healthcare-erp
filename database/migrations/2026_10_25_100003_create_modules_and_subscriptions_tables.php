<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price_monthly', 10, 2)->default(0.00);
            $table->decimal('price_yearly', 10, 2)->default(0.00);
            $table->integer('max_branches')->default(1);
            $table->integer('max_staff')->default(10);
            $table->integer('max_patients')->default(500);
            $table->integer('storage_quota_mb')->default(5120);
            $table->json('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('organization_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscription_plan_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('active'); // active, trialing, past_due, canceled, paused
            $table->string('billing_cycle')->default('monthly'); // monthly, yearly
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamps();
        });

        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->default('core'); // core, clinical, diagnostics, commerce, operations, engagement, intelligence
            $table->string('version')->default('1.0.0');
            $table->json('dependencies')->nullable();
            $table->boolean('is_core')->default(false); // cannot be disabled if true
            $table->boolean('is_active_default')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });

        Schema::create('module_activations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('module_key');
            $table->boolean('is_enabled')->default(true);
            $table->json('settings')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamps();

            $table->unique(['organization_id', 'branch_id', 'module_key']);
            $table->foreign('module_key')->references('key')->on('modules')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_activations');
        Schema::dropIfExists('modules');
        Schema::dropIfExists('organization_subscriptions');
        Schema::dropIfExists('subscription_plans');
    }
};
