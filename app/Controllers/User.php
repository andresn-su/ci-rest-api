<?php namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
	public function index()
	{
        $user = new UserModel();

        $data = $user->findAll();
		return json_encode($data, JSON_UNESCAPED_UNICODE);

	}

	//--------------------------------------------------------------------


    // Função que adiciona um novo user no banco de dados
    public function create()
    {
        $data = $_POST;
        $user = new UserModel();
        $response = [];

        // Faz a inserção no banco e retorna uma mensagem
        try {
            if($data['name'] == '' || $data['email'] == ''){
                throw new \Exception("Preencha todos os campos.", 1);
            } else {
                $user->insert($data);

                $response = [
                    'status' => 200,
                    'message' => 'Dados inseridos com sucesso!'
                ];
            }

        } catch (\Throwable $th) {
            $response = [
                'status' => 200,
                'error' => $th->getMessage()
            ];
        }
        return json_encode($response);
    }


    // Deleta dados do banco de dados
    // metodo post, user/deleteuser/:id
    public function delete($id = null)
    {
        $response = [];
        $user = new UserModel();

        if(!$id){
            $response = [
                'status' => 200,
                'error' => 'Usuário não encontrado.'
            ];

            return json_encode($response);
        } else {
            try {
                $user->delete($id);
                $response = [
                    'status' => 200,
                    'message' => 'Usuário removido.'
                ];
                return json_encode($response);
            } catch (\Throwable $th) {
                $response = [
                    'status' => 200,
                    'error' => 'Falha ao deletar usuário.'
                ];
                return json_encode($response);
            }
        }
    }


    // Método que atualiza um user
    public function update($id)
    {
        $user = new UserModel();
        $data = [];
        parse_str(file_get_contents("php://input"), $data);
        $response = [];

        try {
            $user->update($id, $data);
            $response = [
                'status' => 200,
                'message' => 'User atualizado!'
            ];
            return json_encode($response);
        } catch (\Throwable $th) {
            $response = [
                'status' => 200,
                'error' => 'Erro ao atualizar user. ' . $th
            ];
            return json_encode($response);
        }
    }


    // Método que retorna um user
    public function show($id)
    {
        $user = new UserModel();
        $data = $user->find($id);

        return json_encode($data);
    }

}
