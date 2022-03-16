<?php

namespace App\Mail;

use App\Pesquisa;
use App\UsuarioMatrizFilial;
use App\UsuarioSistema;
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

    public function __construct(UsuarioSistema $user, Pesquisa $search)
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
        $this->to($this->user->usu_email, $this->user->usu_nome);

        return $this->markdown('mail.notifyOperatorNewSearch', [
            'user' => $this->user,
            'search' => $this->search
        ]);
    }
}
