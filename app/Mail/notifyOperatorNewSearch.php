<?php

namespace App\Mail;

use App\Pesquisa;
use App\UsuarioMatrizFilial;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class notifyOperatorNewSearch extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $user;
    private $search;

    public function __construct(UsuarioMatrizFilial $user, Pesquisa $search)
    {
        $this->user = $user;
        $this->search = $search;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Nova Pesquisa!');
        $this->to($this->user->email, $this->user->nome);

        return $this->markdown('mail.notifyOperatorNewSearch', [
            'user' => $this->user,
            'search' => $this->search
        ]);
    }
}
