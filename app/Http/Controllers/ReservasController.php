<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Equipamento;
use App\Models\Local;
use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Redirect;

class ReservasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $reservas = Reserva::with('equipamento')->with('local')->with('cliente')->paginate(25);
        Paginator::useBootstrap();

        return view('reserva.lista', compact('reservas'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $equipamentos = Equipamento::select('nome','id')->pluck('nome','id');
        $locais = Local::select('nome','id')->pluck('nome','id');
        $clientes = Cliente::select('nome','id')->pluck('nome','id');
        return view('reserva.formulario', compact('equipamentos', 'locais', 'clientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reserva = new Reserva();
        $reserva->fill($request->all());
        if ($reserva->save()){
            $equipamentos = 'mensagem_sucesso';
            $locais = 'mensagem_sucesso';
            $clientes = 'mensagem_sucesso';
            $msg = "Reserva salvo!";
        } else {
            $equipamentos = 'mensagem_erro';
            $locais = 'mensagem_erro';
            $clientes = 'mensagem_erro';
            $msg = 'Deu erro';
        }
        return Redirect::to('reserva/create')
                    ->with($equipamentos, $msg)->with($locais, $msg)->with($clientes, $msg);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        $reserva = Reserva::findOrFail($reserva->id);
        $equipamentos = Equipamento::select('nome','id')->pluck('nome','id');
        $locais = Local::select('nome','id')->pluck('nome','id');
        $clientes = Cliente::select('nome','id')->pluck('nome','id');
        return view('reserva.formulario', compact('equipamentos', 'locais', 'clientes', 'reserva'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        $reserva = Reserva::findOrFAil($reserva->id);
        $reserva->fill($request->all());
        if ($reserva->save()){
            $equipamentos = 'mensagem_sucesso';
            $locais = 'mensagem_sucesso';
            $clientes = 'mensagem_sucesso';
            $msg = "Reserva alterado!";
        } else {
            $equipamentos = 'mensagem_erro';
            $locais = 'mensagem_erro';
            $clientes = 'mensagem_erro';
            $msg = 'Deu erro';
        }
        return Redirect::to('reserva/'.$reserva->id)
                    ->with($equipamentos, $msg)->with($locais, $msg)->with($clientes, $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        $reserva = Reserva::findOrFAil($reserva->id);
        if ($reserva->delete()){
            $equipamentos = 'mensagem_sucesso';
            $locais = 'mensagem_sucesso';
            $clientes = 'mensagem_sucesso';
            $msg = "Reserva removido!";
        } else {
            $equipamentos = 'mensagem_erro';
            $locais = 'mensagem_erro';
            $clientes = 'mensagem_erro';
            $msg = 'Deu erro';
        }
        return Redirect::to('reserva')
            ->with($equipamentos, $msg)->with($locais, $msg)->with($clientes, $msg);
    }

    public function devolver($reserva_id){
        $reserva = Reserva::findOrFail($reserva_id);
        $reserva->devolucao = Carbon::now('America/Sao_Paulo');
        if ($reserva->save()){
            $tipo = 'mensagem_sucesso';
            $msg = 'Reserva alterado!';
        }
        else{
            $tipo = 'mensagem_erro';
            $msg = 'Deu erro!';
        }
        return Redirect::to('reserva')->with($tipo, $msg);
    }
}
