<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Message;

class ReturnResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages:return
                            {--id=* : The messages IDs for result to send}
                            
                            {--contents=* : The messages contents of the result to send}
                            
                            {--transaction=* : The messages transaction ids of the result to send}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends results back to sender';

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
        //app('db')->enableQueryLog();
        
        $this->table(['id', 'transaction id', 'content', 'returned'],
            $this->resultsTosend()
            ->transform(function($message){
                
                return [
                    $message->id,
                    $message->transaction_id,
                    $message->contents,
                    
                    # successfully sent?
                    ($message->returnResult() ? 'yes' : 'no')
                ];
            })
        );
        
        //app('log')->debug(app('db')->getQueryLog());
    }
    
    private function resultsTosend()
    {
        $query = Message::toReturn();
        
        collect([
            'id'                     => $this->option('id'),
            'contents'               => $this->option('contents'),
            'transaction_id' => $this->option('transaction')
        ])
        ->each(function($array, $field) use ($query)
        {
            if(! empty($array))
            {
                $query->whereIn($field, $array);
            }
        });

        return  $query->get();
    }
}
