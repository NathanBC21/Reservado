<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use App\Models\Local;
use App\Models\Reserva;
use App\Models\Tipo;
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

        return view('reserva.formulario', compact('reservas'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $equipamentos = Equipamento::select('id', 'nome', 'data_aquisicao')->pluck('id', 'nome', 'data_aquisicao');
        $locais = Local::select('id', 'nome', 'endereco')->pluck('id', 'nome', 'endereco');
        return view('reserva.formulario', compact('locais', 'equipamentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reserva = new Reserva();
        $reserva->fill($request->all());
        if ($reserva->save()){
            $tipo = 'mensagem_sucesso';
            $msg = "Reserva salvo!";
        } else {
            $tipo = 'mensagem_erro';
            $msg = 'Deu erro';
        }
        return Redirect::to('reserva/create')
                    ->with($tipo, $msg);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        $reserva = Reserva::findOrFail($reserva->id);
        $tipos = Tipo::select('titulo', 'id')->pluck('titulo', 'id');
        return view('reserva.formulario', compact('tipos', 'reserva'));
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
            $tipo = 'mensagem_sucesso';
            $msg = "Reserva alterado!";
        } else {
            $tipo = 'mensagem_erro';
            $msg = 'Deu erro';
        }
        return Redirect::to('reserva/'.$reserva->id)
                    ->with($tipo, $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        $reserva = Reserva::findOrFAil($reserva->id);
        if ($reserva->delete()){
            $tipo = 'mensagem_sucesso';
            $msg = "Reserva removido!";
        } else {
            $tipo = 'mensagem_erro';
            $msg = 'Deu erro';
        }
        return Redirect::to('reserva')->with($tipo, $msg);
    }
}
