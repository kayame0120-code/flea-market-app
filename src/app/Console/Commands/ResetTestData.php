<?php

namespace App\Console\Commands;

use App\Models\Comment;
use App\Models\Item;
use App\Models\Like;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ResetTestData extends Command
{
    protected $signature = 'reset:test-data
        {--after= : この日時より後に作られたuser/itemをテストデータとみなして削除する（例: "2026-06-16 00:00:00"）}
        {--inspect : 削除は行わず、created_atの分布だけ表示してcutoffの目安を出す}
        {--dry-run : 実際には削除せず、削除対象の件数だけ表示する}';

    protected $description = 'purchases/likes/commentsは全件、users/itemsは指定日時より後に作られた分だけを削除する';

    public function handle(): int
    {
        if ($this->option('inspect')) {
            return $this->inspect();
        }

        $after = $this->option('after');
        if (! $after) {
            $this->error('--after="YYYY-MM-DD HH:MM:SS" を指定してください。まず --inspect で境目を確認してください。');
            return self::FAILURE;
        }
        $cutoff = Carbon::parse($after);

        $testItemIds = Item::where('created_at', '>', $cutoff)->pluck('id');
        $testUserIds = User::where('created_at', '>', $cutoff)->pluck('id');

        $this->line("cutoff: {$cutoff}");
        $this->line('purchases: 全' . Purchase::count() . '件を削除');
        $this->line('comments: 全' . Comment::count() . '件を削除');
        $this->line('likes: 全' . Like::count() . '件を削除');
        $this->line("items: {$testItemIds->count()}件を削除（cutoff以降作成分）");
        $this->line("users: {$testUserIds->count()}件を削除（cutoff以降作成分）");

        if ($this->option('dry-run')) {
            $this->info('dry-runのため実際の削除は行いません。');
            return self::SUCCESS;
        }

        if (! $this->confirm('この内容で削除を実行します。よろしいですか？', false)) {
            $this->info('中止しました。');
            return self::SUCCESS;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Purchase::truncate();
        Comment::truncate();
        Like::truncate();

        DB::table('item_category')->whereIn('item_id', $testItemIds)->delete();
        Item::whereIn('id', $testItemIds)->delete();
        User::whereIn('id', $testUserIds)->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->info('削除完了。');

        return self::SUCCESS;
    }

    private function inspect(): int
    {
        $this->info('--- users ---');
        User::select('id', 'created_at')
            ->orderBy('created_at')
            ->get()
            ->each(fn($u) => $this->line("id={$u->id}  created_at={$u->created_at}"));

        $this->info('--- items ---');
        Item::select('id', 'created_at')
            ->orderBy('created_at')
            ->get()
            ->each(fn($i) => $this->line("id={$i->id}  created_at={$i->created_at}"));

        $this->line('seed行の塊の直後、テスト行が始まる直前の時刻を --after に指定してください。');

        return self::SUCCESS;
    }
}
