<?php

namespace App\Mail;

use Carbon\Carbon;
use Crypt_GPG;
use GPG;
use GPG_Public_Key;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class PGPMail extends Mailable
{
    use Queueable, SerializesModels;


    public $name, $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $message)
    {
        $this->name = $name;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         // Set the path to your private key and passphrase
        $passphrase = env('GPG_PASSPHRASE');
	    $message = 'I am available to interview on Monday at 2pm GMT+3';
	    $user_id = env('GPG_USER_ID');

        // Use shell_exec to sign the message
        $command = "echo '$message' | gpg --armor --sign --local-user '$user_id' --pinentry-mode loopback --passphrase '$passphrase'";
        $signedMessage = shell_exec($command);

	    $filename = storage_path('result-'.Carbon::now()->toDateTimeString().'.asc');  // Name of the new file

	    // Create and open the file for writing (use 'w' for write mode)
	    $file = fopen($filename, 'w');

	    // Write data to the file
	    fwrite($file, $signedMessage);

	    // Close the file to save changes
	    fclose($file);
        
        $this->subject('Interview Availability')
            ->from(env('MAIL_FROM_ADDRESS'))
            ->to('cecile@womenfirstdigital.org')
            ->view('mail.pgp')->with([
                'name' => $this->name,
                'content' => 'Please find attached my availability'
            ]);
        $this->attach($filename);
        $this->attach(storage_path('my-public-key.asc'));
        return $this;
    }
}
