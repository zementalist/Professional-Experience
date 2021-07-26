<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use DateTime;
use App\Image;
use App\Audio;
use App\Video;
use App\Compressed;
use App\Document;
class TruncateOldFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete files that its time is end';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $models = array(new Image, new Audio, new Video, new Document, new Compressed);
        foreach($models as $model) {
            // Delete file that kept for 4 hours //
            $model::where([['created_at', '<=', date('Y-m-d H:i:s',time()-60*60*4)],
            ['keepfor', '=', '0']])->each(function ($file) {
                Storage::delete('/public/files/' . $file->type . '/' . $file->name);
                $file->delete();
            });
            // Delete files that kept for 1 day //
            $model::where([['created_at', '<=', date('Y-m-d H:i:s',time()-60*60*24)],
            ['keepfor', '=', '1']])->each(function ($file) {
                Storage::delete('/public/files/' . $file->type . '/' . $file->name);
                $file->delete();
            });
        }
    }
}
