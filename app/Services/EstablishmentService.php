<?php

namespace App\Services;
use Illuminate\Http\Response;
use App\Models\Establishment;

class EstablishmentService
{
    protected $establishment;
    protected $pageLimit;

    public function __construct(Establishment $establishment){
            $this->establishment = $establishment;
            $this->pageLimit = 10;
    }
    public function index($request)
    {
       $data = $this->establishment->orderBy('name');
        if ($request->filled('search')) {
            $data = $data->where('name' , 'ILIKE' , '%' . $request->search . '%');
        }
        if ($request->filled('limit')) {
            $data = ["data" => $this->establishment->get()];
            return response()->json($data, Response::HTTP_OK );
        } else {
            $page_limit = $request->filled('per_page') ? $request->per_page : config($this->pageLimit);
            $data = $data->paginate($page_limit);
        }
        return response()->json($data, Response::HTTP_OK );
    }
    public function store($request)
    {
        $dataFrom = $request->all();
        try {
            $data = $this->establishment->create($dataFrom);
            return response()->json($data,Response::HTTP_CREATED ) ;
        }
        catch (\Exception $e) {
            return response()->json(["message"=>'Não foi possível cadastrar',"error"=>$e], Response::HTTP_NOT_ACCEPTABLE );
        }
    }
    public function show($id)
    {
        $data = $this->establishment->find($id);
        if(!$data){
            return response()->json(['error'=>'Dados não encontrados'],Response::HTTP_NOT_FOUND) ;
        }
        return response()->json($data,Response::HTTP_OK ) ;
    }
    public function update($request, $id)
    {
        $data = $this->establishment->find($id);
        if(!$data){
            return response()->json(['error'=>'Dados não encontrados'],Response::HTTP_NOT_FOUND) ;
        }
        $dataFrom = $request->all();
        try {
            $data->update($dataFrom);
            return response()->json($data,Response::HTTP_OK ) ;
            }
        catch (\Exception $e)
             {
             return response()->json(["message"=>'Não foi possível atualizar',"error"=>$e], Response::HTTP_NOT_ACCEPTABLE );
            }
    }

    public function destroy($id)
    {
        $data = $this->establishment->find($id);
        if(!$data){
            return response()->json(['error'=>'Dados não encontrados'],Response::HTTP_NOT_FOUND) ;
        }
         try {
                $data->delete();
                return response()->json(['success'=>'Deletado com sucesso.'],Response::HTTP_OK ) ;
         }
        catch (\Exception $e)
             {
                return response()->json(["message"=>'Não foi possível excluir',"error"=>$e], Response::HTTP_NOT_ACCEPTABLE );
            }
    }

}
