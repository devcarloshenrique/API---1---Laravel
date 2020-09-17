<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->all();
        return response()->json(['data' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validate = validator($data, $this->product->rules());

        if ($validate->fails()) {
            $messages = $validate->messages();

            return response()->json(['validate.error', $messages]);
        }

        if (!$insert = ['result' => $this->product->create($data)]) {
            return response()->json(['error' => 'Error insert'], 500);
        }

        return response()->json($insert);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$product = $this->product->find($id))
            return response()->json(['error' => 'not_found']);

        //Retorna error
        //$product = $this->product->findOrFail($id);

        return response()->json(['data' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = $this->product->find($id);

        $data = $request->all();

        /*
         * Validação de campos
         */
        $validate = validator($data, $this->product->rules($id));

        if ($validate->fails()) {
            $messages = $validate->messages();

            return response()->json(['validate.error', $messages]);
        }

        /**
         * Validação, verificando se o produto realmente existe
         */

        if (!$product)
            return response()->json(['error' => 'not_found']);

        /**
         * Realizando o update, caso o update retorne false, será retornado o erro
         */

        if (!$update = $product->update($data))
            return response()->json(['error' => 'product_not_update'], 500);

        /**
         * Retorna os dados que foram atualizados no if anterior
         */
        return response()->json(['data' => $update]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->product->find($id);

        if (!$product)
            return response()->json(['error' => 'not_found']);

        if (!$delete = $product->delete())
            return response()->json(['error' => 'product_not_delete'], 500);

        return response()->json(['data' => $delete]);
    }
}
