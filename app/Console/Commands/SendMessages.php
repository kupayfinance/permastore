<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Message;

class SendMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages:send
                            {--id=* : The IDs of the messages to send}
                            
                            {--contents=* : The contents of the messages to send}
                            
                            {--transaction=* : The transaction ids of the messages to send}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends stored messages to blockchain';

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
        
        $this->table(['id', 'transaction id', 'content', 'sent'],
            $this->messagesTosend()
            ->transform(function($message){
                
                return [
                    $message->id,
                    $message->transaction_id,
                    $message->contents,
                    
                    # successfully sent?
                    ($message->send() ? 'yes' : 'no')
                ];
            })
        );
        
        //app('log')->debug(app('db')->getQueryLog());
    }
    
    private function messagesTosend()
    {
        $query = Message::toSend();
        
        collect([
            'id'             => $this->option('id'),
            'contents'       => $this->option('contents'),
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
