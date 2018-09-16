<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeploymentController extends Controller
{
    public function deploy(Request $request)
    {
        $commands = ['cd /var/www/my-site', 'git pull'];
        $signature = $request->header('X-Hub-Signature');
        $payload = file_get_contents('php://input');
        if ($this->isFromGithub($payload, $signature)) {
            foreach ($commands as $command) {
               Log::info(shell_exec($command)) ;
               Log::info(system("whoami")) ;
            }
            http_response_code(200);
        } else {
            abort(403);
        }
    }
    private function isFromGithub($payload, $signature)
    {
        return 'sha1=' . hash_hmac('sha1', $payload, env('GITHUB_DEPLOY_TOKEN'), false) === $signature;
    }
}