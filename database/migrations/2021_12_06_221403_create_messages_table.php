<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            
            /* ----- receive and save the message ----- */
            
            # belongs to an API Key
            $table->unsignedBigInteger('key_id');
            
            # message_identifier, we create it and send on response
            $table->uuid('transaction_id')->unique();
            
            # what we receive from requester
            $table->text('payload');
            
            # what we send the to our blockchain node to be stored
            $table->string('contents', 255);
            
            $table->string('format', 64)->default('plaintext');
            
            # when the request arrived
            $table->timestamp('received_at')->nullable();
            
            /* ----- send the request to node -----*/
            
            # what we send to blockchain node
            $table->text('sent_payload')->nullable();
            
            # when the request was sent to the our blockchain node
            $table->timestamp('sent_at')->nullable();
            
            /* ----- send results back to requester ----- */
            
            # results we send to requester
            $table->text('return_payload')->nullable();
            
            # when the results were sent to the requester
            $table->timestamp('returned_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
