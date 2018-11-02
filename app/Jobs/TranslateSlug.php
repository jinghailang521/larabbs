<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;
use Illuminate\Support\Facades\Log;

class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务最大尝试次数
     *
     * @var int
     */
    public $tries = 1;

    /**
     * 任务运行的超时时间。
     *
     * @var int
     */
    public $timeout = 120;

    protected $topic;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Topic $topic)
    {
        //队列任务构造器中接收element模型，将会只序列化模型的ID
        $this->topic = $topic;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //请求接口
        $slug = app(SlugTranslateHandler::class)->translate($this->topic->title);
        file_put_contents(
            storage_path( 'logs/slug.log'  ),
            '【' . date( 'Y-m-d H:i:s', $_SERVER[ 'REQUEST_TIME' ] ) . '】 翻译结果为：'.$slug . PHP_EOL,
            FILE_APPEND
        );
        return false;
        \DB::table('topics')->where('id',$this->topic->id)->update(['slug',$slug]);
    }
}
