<?php

$confibot = json_decode(file_get_contents('./resource/conf.json') , true);

function clientes($message){
	$chat_id = $message["chat"]["id"];
	$from_id = $message["from"]["id"];

	$text = strtolower($message['text']);
	preg_match_all('/[a-z-A-Z-0-9]*+/', $text, $args);
	$args = array_values(array_filter($args[0]));
	$cmd = $args[0];

	atualizasaldo($chat_id);

	if ($cmd == 'start'){
	    
		$nome = $message['from']['first_name'];
		$idwel = $message['from']['id'];
		$conf = json_decode(file_get_contents("./resource/conf.json") , true);

		if ($conf['welcome'] != ""){
			$txt = $conf["welcome"];

			$txt = str_replace("{nome}", $nome, $txt);
			$txt = str_replace("{id}", $idwel, $txt);
			$teste8455 = l(100000);

		}else{
			$txt = "*Ola $nome , User meus comandos Abaixo para Interagir comigo !* $teste8455";
		}
		

		$menu =  ['inline_keyboard' => [

		[['text'=>"🛒COMPRAR CCS🛒",'callback_data'=>"loja"]], [['text'=>"💎SUAS INFORMAÇOES💎",'callback_data'=>"menu_infos"]]

		,]];
		bot("sendMessage",array("chat_id"=> $chat_id , "text" => $txt,"reply_markup" =>$menu,"reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown'));
	 
	}if (preg_match("/[0-9]{6}/", $message['text'])){

		buscabin($message);
		die;
	}

	if (preg_match("/[0-9-A-Z]{10}/", $message['text'],$cod)){

		usagift($message,$cod[0]);
		die();
	}

	if ($cmd == "country"){
		selectbase($message);
		die;
	}

	// bot("sendMessage" , array("chat_id" => $chat_id , "text" => $cmd));

}




function query($msg){
	

	$idquery = $msg['id'];
	$idfrom = $msg['from']['id'];
	$message = $msg['message'];
	$dataquery = $msg['data'];

	$userid = $msg['from']['id'];
	$userid2 = $msg['message']['reply_to_message']['from']['id'];
	$chatid = $msg['message']['chat']['id'];

	if ($userid != $userid2){
		bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "sem permissao !","show_alert"=>false,"cache_time" => 10));
		die();
	}

	if (explode("_", $dataquery)[0] == "volta"){
		$cmd = explode("_", $dataquery)[1];
		$cmd($message);

	}else if (explode("_", $dataquery)[0] == "compracc"){
		$cmd = explode("_", $dataquery)[0];
		$cmd($message,$msg,explode("_", $dataquery)[1]);

	}else if (explode("_", $dataquery)[0] == "altercc"){
		$cmd = explode("_", $dataquery)[0];
		$cmd($message,explode("_", $dataquery)[1],explode("_", $dataquery)[2],$msg);

	}else if (explode("_", $dataquery)[0] == "compramix"){
		$cmd = explode("_", $dataquery)[0];
		$cmd($message,explode("_", $dataquery)[1],explode("_", $dataquery)[2],$msg);

	}else if (explode("_", $dataquery)[0] == "alterValue"){
		$cmd = explode("_", $dataquery)[0];
		$cmd($message,$msg,explode("_", $dataquery)[1],explode("_", $dataquery)[2],explode("_", $dataquery)[3]);

	}else if (explode("_", $dataquery)[0] == "altermix"){
		$cmd = explode("_", $dataquery)[0];
		$cmd($message,$msg,explode("_", $dataquery)[1],explode("_", $dataquery)[2],explode("_", $dataquery)[3]);

	}else if (explode("_", $dataquery)[0] == "comprasearch"){
		$cmd = explode("_", $dataquery)[0];
		$cmd($message,explode("_", $dataquery)[1],explode("_", $dataquery)[2],$msg);

	}else if (explode("_", $dataquery)[0] == "altersaldoe"){
		$cmd = explode("_", $dataquery)[0];
		$cmd($message,$msg,explode("_", $dataquery)[1],explode("_", $dataquery)[2]);

	}else if (explode("_", $dataquery)[0] == "users"){
		$cmd = explode("_", $dataquery)[0];
		$cmd($message,$msg,explode("_", $dataquery)[1],explode("_", $dataquery)[2]);

	}else if (explode("_", $dataquery)[0] == "select"){
		$cmd = explode("_", $dataquery)[0];
		$cmd($message,$msg,explode("_", $dataquery)[1]);

	}else if (explode("_", $dataquery)[0] == "viewcard"){
		$cmd = explode("_", $dataquery)[0];
		$cmd($message,$msg,explode("_", $dataquery)[1],explode("_", $dataquery)[2]);

	}else if (explode("_", $dataquery)[0] == "altercard"){
		$cmd = explode("_", $dataquery)[0];
		$cmd($message,$msg,explode("_", $dataquery)[1],explode("_", $dataquery)[2],explode("_", $dataquery)[3],explode("_", $dataquery)[4]);

	}else if (explode("_", $dataquery)[0] == "compraccs"){
		$cmd = explode("_", $dataquery)[0];
		
		$cmd($message,$msg,explode("_", $dataquery)[1],explode("_", $dataquery)[2],explode("_", $dataquery)[3]);

	}else if (explode("_", $dataquery)[0] == "envia"){
		$cmd = explode("_", $dataquery)[0];
		
		$cmd($message,$msg,explode("_", $dataquery)[1] , explode("_", $dataquery)[2] , explode("_", $dataquery)[3] );

	}else{
		$dataquery($message);
	}
}




/*alter user*/


function users($message , $query , $type , $position){


	
	$chat_id = $message["chat"]["id"];
	$idquery = $query['id'];


	$users = json_decode(file_get_contents("./usuarios.json"),true);

	
	$chunk = array_chunk($users, 10);

	$tt = sizeof($chunk);


	if ($type == "prox"){
		if ($chunk[ $position + 1]){
			
			$postio4n = $position +1;
		}else{
			die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "cabou kkk !!!","show_alert"=> false,"cache_time" => 10)));
		}
	}else{
		if ($chunk[ $position - 1]){
			
			$postio4n = $position  - 1;

		}else{
			die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "cabou kkk !!!","show_alert"=> false,"cache_time" => 10)));
		}
	}

	$userss = $chunk[$postio4n];

	$indexs = array_chunk(array_keys($users), 10)[$postio4n];

	$t = sizeof($chunk);

	$d = $postio4n +1;

	$txt .= "<b>✨LISTA DE USUARIOS DO BOT\n🍃mostrando: $d de $t</b>\n";
	foreach ($userss as $iduser => $value44) {

		$idcarteira = $indexs[$iduser];

		$nome = ($value44['nome'])? $value44['nome'] : "Sem Nome";

		$nome = str_replace(["</>" ], "", $nome);
		$saldo = ($value44['saldo']) ? $value44['saldo'] : 0;

		$dadta = (date("d/m/Y H:s:i" , $value44['cadastro']))? date("d/m/Y H:s:i" , $value44['cadastro']) : "Sem Data";

		$txt .= "\n🧰<b>Id da carteira:</b> {$idcarteira}\n";
		$txt .= "💎<b>Nome: </b>{$nome}\n";
		$txt .= "💰<b>Saldo: </b> {$saldo}\n";
		$txt .= "📅<b>Data Cadastro: </b> {$dadta}\n";

	}

	$menu =  ['inline_keyboard' => [

	[
		['text'=>"<<",'callback_data'=>"users_ant_{$postio4n}"] , ['text'=>">>",'callback_data'=>"users_prox_{$postio4n}"]
	] ,[
		['text'=>"🔙Volta",'callback_data'=>"menu"]
	]

	,]];

	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_to_message_id"=> $message['message_id'],  "parse_mode" => "html","reply_markup" =>$menu));




}


/*

envia msg para os users 

*/

function envia($message , $query , $opt , $postion ){
	$chat_id = $message["chat"]["id"];
	$dados = json_decode(file_get_contents("./usuarios.json") , true);
	$idquery = $query['id'];
	$msg = file_get_contents("./msgs.txt");

	$t = sizeof(array_chunk(array_keys($dados), 50));

	$json = array_chunk(array_keys($dados), 50)[$postion];
	if (!array_chunk(array_keys($dados), 50)[$postion]){
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Todos os usuarios ja receberam a msg !!!","show_alert"=> false,"cache_time" => 10)));
	}

	$tenviados = 0;
	$tnenviados = 0;
	$usersdell = [];

	$nenv = $postion +1;

	foreach ($json as $value) {

		$sendmessage = bot("sendMessage" , array("chat_id" => $value , "text" => $msg , "parse_mode" => "Markdown" ));

		if (!$sendmessage){
			
			if ($opt == "sim" || $opt == 'sim'){
				delluser($value);
				$usersdell[] = $value;
			}
			$tnenviados++;
		}else{
			$tenviados++;
		}

	}

	$usersap = implode(",", $usersdell);

	$txt .= "<b>✨ Enviando .. !</b>\n\n";
	$txt .= "<b>📩 Msg: {$msg}</b>\n\n";
	$txt .= "<b>🔝 Enviado {$nenv} de {$t} !</b>\n";
	$txt .= "<b>✅ Enviados: {$tenviados}!</b>\n";
	$txt .= "<b>❌ Nao Enviados: {$tnenviados} !</b>\n";
	$txt .= "<b>🗑 Users Apagados: {$usersap}!</b>\n";

	$postio4n = $position++;

	$menu =  ['inline_keyboard' => [
		[ 
			['text'=>"continua",'callback_data'=>"envia_{$opt}_{$postio4n}"]
		]
	,]];

	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_to_message_id"=> $message['message_id'],"parse_mode" => 'html',"reply_markup" =>$menu));
}



/*

	perfil usuario !

*/


function menu_infos($message){
	$chat_id = $message["chat"]["id"];

	$historicocc = json_decode(file_get_contents("./ccsompradas.json") , true);
	$dados = json_decode(file_get_contents("./usuarios.json") , true);
	$historicosaldo = json_decode(file_get_contents("./salcocomprado.json") , true);
	
	$conf = json_decode(file_get_contents("./resource/conf.json") , true);

	$cliente = $dados[$chat_id];
	$menu =  ['inline_keyboard' => [[],]];

	$botoes[] = ['text'=>"💳 ccs compradas",'callback_data'=>"ccscompradas"];
	$botoes[] = ['text'=>"💳 mixs comprados",'callback_data'=>"mixscomprados"];
	$botoes[] = ['text'=>"💰 saldo comprado",'callback_data'=>"saldocomprado"];
	$botoes[] = ['text'=>"🔚 Volta",'callback_data'=>"volta_menu"];
	$menu['inline_keyboard'] = array_chunk($botoes, 2);

	$txt = '✨*Suas Informacoes:*'."\n\n";
	$txt .= "*Nome:* _{$cliente[nome]}_\n";
	$txt .= ($cliente['username']) ? "*User:* _{$cliente[username]}_\n": "*User:* _sem user_\n";
	$txt .= ($cliente['adm'] == "true") ? "*Admin:* _sim_\n" : "*Admin:* _nao_\n";
	$txt .= ($cliente['cadastro']) ? "*Data de cadastro*: _".date("d/m/Y H:i:s" , $cliente['cadastro'])."_\n" : "*Data de cadastro:* _sem registro_\n";
	$txt .= "*ID da carteira:* `$chat_id`\n";
	$txt .= "*Saldo:* {$cliente[saldo]}\n";
	$txt .= "\n🛒*Compras Realizadas:*\n";
	$totalccs = (sizeof($historicocc[$chat_id]['ccs'])) ? sizeof($historicocc[$chat_id]['ccs']) : 0 ;
	$txt .= "💳*Cc's compradas:* $totalccs\n";
	$totalmixs = (sizeof($historicocc[$chat_id]['mixs'])) ? sizeof($historicocc[$chat_id]['mixs']) : 0 ;
	$txt .= "💳*Mixs comprados:* $totalmixs\n";

	$txt .= "\n⚙️*Informações do bot*\n";
	//$txt .= "💾*Versão:* _{$conf[versao]}_\n";
	$txt .= "📆*Date Create:* 29/09/2021\n";
	//$txt .= "📥*Ultima Atualização:* _{$conf[updateDAte]}_\n";
	$txt .= "👤*Criador:* _@Mandrackdf_\n";
	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown',"reply_markup" =>$menu));
}



/*
	ver saldo comprado!
*/


function saldocomprado($message){
	$saldocomprado = json_decode(file_get_contents("./salcocomprado.json") , true);

	$chat_id = $message["chat"]["id"];
	$b = [];
	$menu =  ['inline_keyboard' => [[],]];
	$b[] = ['text'=>"⬅️",'callback_data'=>"altersaldoe_ant_0"];
	$b[] = ['text'=>"➡️",'callback_data'=>"altersaldoe_prox_0"];
	$b[] = ['text'=>"🔚 Volta",'callback_data'=>"menu_infos"];
	$menu['inline_keyboard'] = array_chunk($b, 2);

	$txt = "✨*Compras de saldo realizadas*\n\n";
	
	if (sizeof($saldocomprado[$chat_id]) <= 0){
		$txt .= "*Ops , vc ainda nao tem nenhuma comprada realizada \!*\n\n";
		die(bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_to_message_id"=> $message['message_id'],  "parse_mode" => 'MarkdownV2',"reply_markup" =>$menu)));
	}

	$dados = $saldocomprado[$chat_id];

	$split = array_chunk($dados, 2);

	$t = sizeof($split);

	$one = $split[0];

	$txt .= "*🔎Mostrando 1 de {$t}*\n\n";

	foreach ($one as $value) {
		$txt .= "*Codigo:* {$value[codigo]}\n";
		$txt .= "*Valor:* {$value[valor]} (saldo)\n";
		$txt .= "*Expira:* ".date("d/m/Y H:i:s" , $value['datelimite'])."\n";
		$txt .= "*Comprado em:* ".date("d/m/Y H:i:s" , $value['date'])."\n\n";
	}
	$confibot = $GLOBALS[confibot];
	$txt .= "_problemas\devolução relatar ao {$confibot[userDono]}_\n";

	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_to_message_id"=> $message['message_id'],  "parse_mode" => 'Markdown',"reply_markup" =>$menu));


}

/*
	altera saldo comprado
*/

function altersaldoe($message,$query,$type , $position){

	$dados = json_decode(file_get_contents("./salcocomprado.json") , true);
	$chat_id = $message["chat"]["id"];
	$idquery = $query['id'];

	$txt = "✨*Compras de saldo realizadas*\n\n";

	$chunk = array_chunk($dados[$chat_id], 2);

	if ($type == "prox"){
		if ($chunk[ $position + 1]){
			
			$postio4n = $position +1;
		}else{
			die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Não a proxima compra !!!","show_alert"=> false,"cache_time" => 10)));
		}
	}else{
		if ($chunk[ $position - 1]){
			
			$postio4n = $position  - 1;

		}else{
			die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Não a compra anterior !!!","show_alert"=> false,"cache_time" => 10)));
		}
	}

	$dadoscc = $chunk[$postio4n];

	$t = sizeof($chunk);

	$d = $postio4n +1;

	$txt .= "*🔎Mostrando {$d} de {$t}*\n\n";

	foreach ($dadoscc as $value) {
		$txt .= "*Codigo:* {$value[codigo]}\n";
		$txt .= "*Valor:* {$value[valor]} (saldo)\n";
		$txt .= "*Expira:* ".date("d/m/Y H:i:s" , $value['datelimite'])."\n";
		$txt .= "*Comprado em:* ".date("d/m/Y H:i:s" , $value['date'])."\n\n";
	}
	
	$confibot = $GLOBALS[confibot];
	$txt .= "_problemas\devolução relatar ao {$confibot[userDono]}_\n";

	$b = [];
	$menu =  ['inline_keyboard' => [[],]];
	$b[] = ['text'=>"⬅️",'callback_data'=>"altersaldoe_ant_{$postio4n}"];
	$b[] = ['text'=>"➡️",'callback_data'=>"altersaldoe_prox_{$postio4n}"];
	$b[] = ['text'=>"🔚 Volta",'callback_data'=>"menu_infos"];
	$menu['inline_keyboard'] = array_chunk($b, 2);

	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_to_message_id"=> $message['message_id'],  "parse_mode" => 'Markdown',"reply_markup" =>$menu));
}


/*

	ver mixs ksks
*/

function mixscomprados($message){

	$historicocc = json_decode(file_get_contents("./ccsompradas.json") , true);

	$chat_id = $message["chat"]["id"];
	$b = [];
	$menu =  ['inline_keyboard' => [[],]];
	$b[] = ['text'=>"⬅️",'callback_data'=>"altermix_ant_0_ccsompradas"];
	$b[] = ['text'=>"➡️",'callback_data'=>"altermix_prox_0_ccsompradas"];
	$b[] = ['text'=>"🔚 Volta",'callback_data'=>"menu_infos"];
	$menu['inline_keyboard'] = array_chunk($b, 2);

	$txt = "✨*Seus Mixs comprados*\n\n";
	
	if (sizeof($historicocc[$chat_id]['mixs']) <= 0){
		$txt .= "*Ops , vc ainda nao tem nenhum mix comprado \!*\n\n";
		die(bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_to_message_id"=> $message['message_id'],  "parse_mode" => 'MarkdownV2',"reply_markup" =>$menu)));
	}
	$dados = $historicocc[$chat_id]['mixs'][0];

	$t = sizeof($historicocc[$chat_id]['mixs']);

	$txt .= "*🔎Mostrando 1 de {$t}*\n\n";
	// $txt .= "*$dados*";
	$txt .= "*{$dados[cc]}*\n\n";

	$txt .= "Mix comprado em: {$dados[date]}\n\n";

	$confibot = $GLOBALS[confibot];
	$txt .= "_problemas\devolução relatar ao {$confibot[userDono]}_\n";
	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_to_message_id"=> $message['message_id'],  "parse_mode" => 'Markdown',"reply_markup" =>$menu));


	
}

/*
	alter mix 
*/

function altermix($message, $query , $type ,$position , $db ){



	$dados = json_decode(file_get_contents("./{$db}.json") , true);

	$chat_id = $message["chat"]["id"];
	$txt = "✨*Suas ccs compradas*\n\n";
	$idquery = $query['id'];

	$txt = "✨*Seus Mixs comprados*\n\n";


	if ($type == "prox"){
		if ($dados[$chat_id]['mixs'][ $position + 1]){
			
			$postio4n = $position +1;
		}else{
			die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Não a proxima cc !!!","show_alert"=> false,"cache_time" => 10)));
		}
	}else{
		if ($dados[$chat_id]['mixs'][ $position - 1]){
			
			$postio4n = $position  - 1;

		}else{
			die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Não a cc anterior !!!","show_alert"=> false,"cache_time" => 10)));
		}
	}

	$dadoscc = $dados[$chat_id]['mixs'][ $postio4n];

	$t = sizeof($dados[$chat_id]['mixs']);

	$d = $postio4n +1;

	$txt .= "*🔎Mostrando {$d} de {$t}*\n\n";
	$txt .= "*".trim($dadoscc[cc])."*\n\n";
	$txt .= "Mix comprado em: {$dadoscc[date]}\n\n";
	
	$confibot = $GLOBALS[confibot];
	$txt .= "_problemas\devolução relatar ao {$confibot[userDono]}_\n";

	$b = [];
	$menu =  ['inline_keyboard' => [[],]];
	$b[] = ['text'=>"⬅️",'callback_data'=>"altermix_ant_{$postio4n}_ccsompradas"];
	$b[] = ['text'=>"➡️",'callback_data'=>"aaltermix_prox_{$postio4n}_ccsompradas"];
	$b[] = ['text'=>"🔚 Volta",'callback_data'=>"menu_infos"];
	$menu['inline_keyboard'] = array_chunk($b, 2);

	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_to_message_id"=> $message['message_id'],  "parse_mode" => 'Markdown',"reply_markup" =>$menu));
}

/*
	ver ccs compradas 
*/

function ccscompradas($message){

	$historicocc = json_decode(file_get_contents("./ccsompradas.json") , true);

	$chat_id = $message["chat"]["id"];
	$b = [];
	$menu =  ['inline_keyboard' => [[],]];
	$b[] = ['text'=>"⬅️",'callback_data'=>"alterValue_ant_0_ccsompradas"];
	$b[] = ['text'=>"➡️",'callback_data'=>"alterValue_prox_0_ccsompradas"];
	$b[] = ['text'=>"🔚 Volta",'callback_data'=>"menu_infos"];
	$menu['inline_keyboard'] = array_chunk($b, 2);

	$txt = "✨*Suas ccs compradas*\n\n";
	
	if (sizeof($historicocc[$chat_id]['ccs']) <= 0){
		$txt .= "*Ops , vc ainda nao tem nenhuma cc comprada \!*\n\n";
		die(bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_to_message_id"=> $message['message_id'],  "parse_mode" => 'MarkdownV2',"reply_markup" =>$menu)));
	}
	$dados = $historicocc[$chat_id]['ccs'][0]['cc'];

	$t = sizeof($historicocc[$chat_id]['ccs']);

	$txt .= "*🔎Mostrando 1 de {$t}*\n\n";
	$txt .= "*💳CC:* {$dados[cc]}\n";
	$txt .= "*💳Bandeira:* {$dados[bandeira]}\n";
	$txt .= "*💳Tipo:* {$dados[tipo]}\n";
	$txt .= "*💳Level:* {$dados[nivel]}\n";
//	$txt .= "*💳Banco:* {$dados[banco]}\n";


	$dia = $historicocc[$chat_id]['ccs'][0]['date'];
	
	$txt .= "*CC Comprada em:* {$dia}\n\n";

	$confibot = $GLOBALS[confibot];
	$txt .= "_problemas\devolução relatar ao {$confibot[userDono]}_\n";

	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_to_message_id"=> $message['message_id'],  "parse_mode" => 'Markdown',"reply_markup" =>$menu));


	
}


/*
	altera cc do perfil
*/
function alterValue($message, $query , $type ,$position , $db ){



	$dados = json_decode(file_get_contents("./{$db}.json") , true);

	$chat_id = $message["chat"]["id"];
	$txt = "✨*Suas ccs compradas*\n\n";
	$idquery = $query['id'];

	$txt = "✨*Suas ccs compradas*\n\n";


	if ($type == "prox"){
		if ($dados[$chat_id]['ccs'][ $position + 1]){
			
			$postio4n = $position +1;
		}else{
			die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Não a proxima cc !!!","show_alert"=> false,"cache_time" => 10)));
		}
	}else{
		if ($dados[$chat_id]['ccs'][ $position - 1]){
			
			$postio4n = $position  - 1;

		}else{
			die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Não a cc anterior !!!","show_alert"=> false,"cache_time" => 10)));
		}
	}

	$dadoscc = $dados[$chat_id]['ccs'][ $postio4n]['cc'];

	$dia = $dados[$chat_id]['ccs'][ $postio4n]['date'];
	$t = sizeof($dados[$chat_id]['ccs']);

	$d = $postio4n +1;

	$txt .= "*🔎Mostrando {$d} de {$t}*\n\n";
	$txt .= "*💳CC:* {$dadoscc[cc]}\n";
	$txt .= "*💳Bandeira:* {$dadoscc[bandeira]}\n";
	$txt .= "*💳Tipo:* {$dadoscc[tipo]}\n";
	$txt .= "*💳Level:* {$dadoscc[nivel]}\n";
//	$txt .= "*💳Banco:* {$dadoscc[banco]}\n";
	$dia = $dados[$chat_id]['ccs'][ $postio4n]['date'];
	$txt .= "*CC Comprada em:* {$dia}\n\n";

	$confibot = $GLOBALS[confibot];
	$txt .= "_problemas\devolução relatar ao {$confibot[userDono]}_\n";
	

	$b = [];
	$menu =  ['inline_keyboard' => [[],]];
	$b[] = ['text'=>"⬅️",'callback_data'=>"alterValue_ant_{$postio4n}_ccsompradas"];
	$b[] = ['text'=>"➡️",'callback_data'=>"alterValue_prox_{$postio4n}_ccsompradas"];
	$b[] = ['text'=>"🔚 Volta",'callback_data'=>"menu_infos"];
	$menu['inline_keyboard'] = array_chunk($b, 2);

	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_to_message_id"=> $message['message_id'],  "parse_mode" => 'Markdown',"reply_markup" =>$menu));
}

/*

 resgata gift / codigo

*/

function usagift($message, $cod){
	
	$chat_id = $message["chat"]["id"];

	$gifts = json_decode(file_get_contents("./gifts.json") , true);
	$users = json_decode(file_get_contents("./usuarios.json") , true);
	$saldocomprado = json_decode(file_get_contents("./salcocomprado.json") , true);

	$menu =  ['inline_keyboard' => [[['text'=>"🔚 Volta",'callback_data'=>"volta_loja"]],]];

	if (!$gifts[$cod]){
		die(bot("sendMessage" , array("chat_id" => $chat_id , "text" => "*Ops, Este codigo nao foi encontrado ! , tente novamente*" , "reply_to_message_id" => $message['message_id'],"parse_mode" => "Markdown")));
	}
	
	$dg = $gifts[$cod];
	$valor = $dg['valor'];

	if ($dg['used'] == "true"){
		die(bot("sendMessage" , array("chat_id" => $chat_id , "text" => "*Desculpe , mas este codigo ja foi usado !*" , "reply_to_message_id" => $message['message_id'],"parse_mode" => "Markdown")));
	}

	// $date = strtotime("now");
	$date = strtotime("+1 week");
	$date1 = strtotime("now");

	$users[$chat_id]['saldo'] = $users[$chat_id]['saldo'] + $valor;
	$users[$chat_id]['dataLimite'] = $date;

	$saldocomprado[$chat_id][] = array("valor" => $valor , "datelimite" => $date , "date" => $date1 , "codigo" => $cod );

	$dsalva = json_encode($users,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT );
	$salva = file_put_contents('./usuarios.json', $dsalva);

	if ($salva){
		$gifts[$cod]['used'] = "true";
		$gifts[$cod]['cliente'] = $chat_id;

		$dsalva = json_encode($gifts,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT );
		$salva = file_put_contents('./gifts.json', $dsalva);
		// atualiza o historico de compradas 
		$dsalva2 = json_encode($saldocomprado,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT );
		$salva = file_put_contents('./salcocomprado.json', $dsalva2);

		bot("sendMessage" , array("chat_id" => $chat_id , "text" => "*💰Opa , O saldo foi adicionado a sua conta💎\nVc pode ver esta compra no seu perfil !*" , "reply_to_message_id" => $message['message_id'],"parse_mode" => "Markdown"));
	}else{
		die(bot("sendMessage" , array("chat_id" => $chat_id , "text" => "*Desculpe , Ocorreu um erro interno !*" , "reply_to_message_id" => $message['message_id'],"parse_mode" => "Markdown")));
	}

}


/*
	compra saldo
*/

function comprasaldo($message){
	$chat_id = $message["chat"]["id"];
	$confibot = $GLOBALS[confibot];

	$txt = "💰 Comprar __saldo__\nPara adicionar saldo à sua conta você deve realizar o pagamento para o {$confibot[userDono]}\n\n";
	$txt .= "*Formas de pagamento*:\n💠PIX \n ";
	$txt .= "💎Apos a *confirmacao do pagamento* vc ira receber um codigo , *me envie que irei add seu saldo*😉\n\n";
	$txt .= "⚠️*Por motivos de seguraca seu saldo tem a Validade de 1 semana*\!";

	$menu =  ['inline_keyboard' => [
		[['text'=>"🔚 Volta",'callback_data'=>"volta_loja"]]
	,]];

	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_to_message_id"=> $message['message_id'],  "parse_mode" => 'MarkdownV2',"reply_markup" =>$menu));
}


/*
	search exemplo do search
*/

function search ($message){
	$chat_id = $message["chat"]["id"];
	$nome = $message['reply_to_message']['from']['first_name'];
	$menu =  ['inline_keyboard' => [

		[['text'=>"🔚 Volta",'callback_data'=>"volta_loja"]]
		,
	]];

	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => "*Vc pode busca ccs em nosso banco de dados pela* _bin _\nUser /search bin\nExemplo: /search 406669\nou simplesmente manda a bin ","reply_markup" =>$menu,"reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown' , 'force_reply' => true , "selective" => true));
}


/*
	busca a bin no json
*/
function buscabin($message){

	$chat_id = $message["chat"]["id"];
	$nome = $message['reply_to_message']['from']['first_name'];
	$pre = preg_match("/[0-9]{6}/", $message['text'],$bin);

	$menu =  ['inline_keyboard' => [

		[]

	,]];
	

	$clientes = json_decode(file_get_contents("./usuarios.json") , true);
	$searchs = json_decode(file_get_contents("./search.json") , true);
	$price = json_decode(file_get_contents("./resource/conf.json") , true)['price'];
	$bin = $bin[0];

	$msgbot = bot("sendMessage",array( "chat_id"=> $chat_id , "text" => "_*Aguarde estou buscando a bin .. $bin*_","reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown'));


	$message_id = json_decode($msgbot , true)['result']['message_id'];

	$ccs = [];
	$country = $clientes[$chat_id]['country'];
	$dir = './ccs/'.$country.'/';

	$itens = scandir($dir);
	
	if ($itens !== false) { 
		foreach ($itens as $item) { 
			$ccs[] =  explode(".", $item)[0];
		}
	}

	$levels = array_values(array_filter($ccs));
	
	$result = [];

	foreach ($levels as $key => $value) {
		$ccs = json_decode(file_get_contents("./ccs/{$country}/{$value}.json") , true);

		foreach ($ccs as $key => $value) {
			if (substr($value['cc'], 0,6) == $bin){
				$value['idcc'] = $key;
				$result[] = $value;
			}
		}
	}

	// bot("editMessageText",array( "message_id" => $message_id  , "chat_id"=> $chat_id , "text" => $result));

	// exit();

	if (empty($result)){
		$confibot = $GLOBALS[confibot];

		die(bot("editMessageText",array( "message_id" => $message_id , "chat_id"=> $chat_id , "text" => "*Nao foi encontrado nenhum resultado para a bin $bin , entre em contato com o nosso vendedor e pergunte se a alguma disponivel em seu estoque* , _vendedor : {$confibot[userDono]}_","reply_markup" =>$menu,"reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown')));

	}

	$botoes = [];


	$dadoscc = $result[0];
	$idcc = $dados['idcc'];
	$level = $dados['nivel'];
	$preco  = ($price[$level]) ? $price[$level] : $price['Default'];

	$saldo = $clientes[$chat_id]['saldo'];

	
	$botoes[] = ['text'=>"⬅️ Ante.",'callback_data'=>"altercc_ant_0"];

	$botoes[] = ['text'=>"🛒Compra cc🛒",'callback_data'=>"comprasearch_{$idcc}_{$level}"];
	
	$botoes[] = ['text'=>"prox. ➡️",'callback_data'=>"altercc_prox_0"];
	$test135 = rand(1,100);
	

	    $txt .= "✅Oʙʀɪɢᴀᴅᴏ Pᴇʟᴀ Cᴏᴍᴘʀᴀ\n\n";
        $txt .= "ɪɴғᴏʀᴍᴀçᴏᴇs:\n";
		$txt .= "Nᴜᴍᴇʀᴏ: `".$dadoscc['cc']."`\n";
		$txt .= "Vᴀʟɪᴅᴀᴅᴇ: `". $dadoscc['mes'] .'/'.$dadoscc['ano'] ."_\n";
		$txt .= "Cᴠᴠ: `{$dadoscc[cvv]}`\n";
		$txt .= "Bᴀɴᴅᴇɪʀᴀ: `$dadoscc[bandeira]`\n";
		$txt .= "Nɪᴠᴇʟ: `$dadoscc[nivel]`\n";
		$txt .= "Tɪᴘᴏ: `$dadoscc[tipo]`\n";
		$txt .= "Sᴀʟᴅᴏ ᴀᴘᴏꜱ ᴀ ᴄᴏᴍᴘʀᴀ: * _{$saldo}_\n";


	$searchs[$chat_id] = $result;
	$dsalva = json_encode($searchs,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT );
	$salva = file_put_contents('./search.json', $dsalva);

	$menu['inline_keyboard'] = array_chunk($botoes, 3);

	$menu['inline_keyboard'][] = [['text'=>"🔚 Volta",'callback_data'=>"volta_loja"]];

	$total = sizeof($result);
		
	bot("editMessageText",array( "message_id" => $message_id  , "chat_id"=> $chat_id , "text" => "*🔎Foi encontrada*  _{$total}_ *ccs com esta bin *_{$bin}_ *no banco de dados !*\n\n$txt","reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown',"reply_markup" =>$menu));


}


/*
	
	altera cc do search!
	
*/

function altercc($message,$type , $postion , $query){

	$chat_id = $message["chat"]["id"];
	$nome = $message['reply_to_message']['from']['first_name'];
	$idquery = $query['id'];

	$ccs = json_decode(file_get_contents("./search.json") , true);

	$ccs = $ccs[$chat_id];

	if ($type == "prox"){

		if ($ccs[ $postion + 1 ]){
			$dados = $ccs[ $postion + 1];
			$postio4n = $postion+1;
			
		}else{
			die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Não a próxima cc!","show_alert"=> false,"cache_time" => 10)));
		}
	}else{

		if ($ccs[$postion -1 ]){
			$dados = $ccs[ $postion - 1 ];
			$postio4n = $postion -1;
		}else{
			die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Não a cc anterior!!!","show_alert"=> false,"cache_time" => 10)));
		}
	}

	

	$dadoscc = $ccs[$postio4n];
	$menu =  ['inline_keyboard' => [[],]];
	$price = json_decode(file_get_contents("./resource/conf.json") , true)['price'];
	$clientes = json_decode(file_get_contents("./usuarios.json") , true);
	$botoes = [];
	$idcc = $dadoscc['idcc'];
	$level = $dadoscc['nivel'];

	$saldo = $clientes[$chat_id]['saldo'];

	$preco  = ($price[$level]) ? $price[$level] : $price['Default'];

	$botoes[] = ['text'=>"⬅️ Ante.",'callback_data'=>"altercc_ant_{$postio4n}"];

	$botoes[] = ['text'=>"🛒Compra cc🛒",'callback_data'=>"comprasearch_{$idcc}_{$level}"];

	$botoes[] = ['text'=>"prox. ➡️",'callback_data'=>"altercc_prox_{$postio4n}"];
	$bin = substr(explode("|", $dados['cc'])[0], 0,6);
	

	$txt .= "✨*Detalhes da cc*\n";
	$txt .= "*💳cc: *_".$bin.'xxxxxxxxx'."_\n";
	$txt .= "📆*mes / ano: *_" . $dadoscc['mes'] .'/'.$dadoscc['ano'] ."_\n";
	$txt .= "🔐*cvv: *_{$dadoscc[cvv]}_\n";
	$txt .= "🏳️*bandeira:* _$dadoscc[bandeira]_\n";
	$txt .= "💠*nivel:* _$dadoscc[nivel]_\n";
	$txt .= "⚜️*tipo:* _$dadoscc[tipo]_\n";
	$txt .= "⚠️*Seu saldo:* _{$saldo}_\n";


	$menu['inline_keyboard'] = array_chunk($botoes, 3);
	$menu['inline_keyboard'][] = [['text'=>"🔚 Volta",'callback_data'=>"volta_loja"]];
	$total = sizeof($ccs);
	
	$bin = substr(explode("|", $dados['cc'])[0], 0,6);

	bot("editMessageText",array( "message_id" => $message['message_id']  , "chat_id"=> $chat_id , "text" => "*Mostrando resultado ".($postio4n + 1)." de {$total} da bin {$bin}*\n\n$txt","reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown',"reply_markup" =>$menu));

	// atualiza($chat_id,$bin);

}

/*
	compra cc do search
*/


function comprasearch ($message , $id , $level , $query){

	$confibot = $GLOBALS[confibot];

	$level = strtolower($level);

	$chat_id = $message["chat"]["id"];
	$nome = $message['reply_to_message']['from']['first_name'];
	$idquery = $query['id'];

	$clientes = json_decode(file_get_contents("./usuarios.json") , true);
	$seach = json_decode(file_get_contents("./search.json") , true);
	$conf = json_decode(file_get_contents("./resource/conf.json") , true);

	$menu =  ['inline_keyboard' => [[],]];
	$menu['inline_keyboard'][] = [['text'=>"🔚 Volta",'callback_data'=>"volta_loja"]];

	if (!$clientes[$chat_id]){
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "usuario sem registro , manda /start para se registra!!","show_alert"=> true,"cache_time" => 10)));
	}

	$price = json_decode(file_get_contents("./resource/conf.json") , true)['price'];

	$valor  = ($price[$level]) ? $price[$level] : $price['Default'];


	$user = $clientes[$chat_id];
	if ($user['saldo'] == 0){
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Vc nao tem saldo suficiente para realiza esta compra!\nCompre saldo com o {$confibot[userDono]}!","show_alert"=> true,"cache_time" => 10)));
	} 

	if (empty($level)){
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "cc nao encontrada!","show_alert"=> false,"cache_time" => 10)));
	}

	if ($valor > $user['saldo']){
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Vc nao tem saldo suficiente para realiza esta compra!\nCompre saldo com o {$confibot[userDono]}!","show_alert"=> true,"cache_time" => 10)));
	} 


	$dadoscc = deletecc($chat_id , $id,$level);

	if (empty($dadoscc)){
		bot("sendMessage" , array("chat_id" => $conf['dono'] , "text" => "base esta sem esta cc's $level !!"));
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Desculpe , mas estou sem cc's $level.\n!","show_alert"=> true,"cache_time" => 10)));
		
	}

	if (removesaldo($chat_id , $valor)){
		

		bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Foi Descontado $valor do seu saldo!! ","show_alert"=> false,"cache_time" => 10));

		salvacompra($cc,$chat_id,"ccs");

		$saldo = $clientes[$chat_id]['saldo'] - $valor;

		$result = json_decode(bot("getMe" , array("vel" => "")) , true);
		$userbot = $result['result']['username'];

		$txt .= "✅Oʙʀɪɢᴀᴅᴏ Pᴇʟᴀ Cᴏᴍᴘʀᴀ\n\n";
        $txt .= "ɪɴғᴏʀᴍᴀçᴏᴇs:\n";
		$txt .= "Nᴜᴍᴇʀᴏ: `".$dadoscc['cc']."`\n";
		$txt .= "Vᴀʟɪᴅᴀᴅᴇ: `". $dadoscc['mes'] .'/'.$dadoscc['ano'] ."_\n";
		$txt .= "Cᴠᴠ: `{$dadoscc[cvv]}`\n";
		$txt .= "Bᴀɴᴅᴇɪʀᴀ: `$dadoscc[bandeira]`\n";
		$txt .= "Nɪᴠᴇʟ: `$dadoscc[nivel]`\n";
		$txt .= "Tɪᴘᴏ: `$dadoscc[tipo]`\n";
		$txt .= "Sᴀʟᴅᴏ ᴀᴘᴏꜱ ᴀ ᴄᴏᴍᴘʀᴀ: * _{$saldo}_\n";

		$menu =  ['inline_keyboard' => [

			[["text" => "🔄 Compra novamente" , "url" => "http://telegram.me/$userbot?start=comprardnv"]]

		,]];

		bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_markup" =>$menu,"reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown'));

		// $bin = substr(explode("|", $cc['cc'])[0], 0,6);

		// atualiza($chat_id,$bin);

		exit();
	}else{
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Ocorreu um error interno , Tente novamente!","show_alert"=> false,"cache_time" => 10)));
	}
}
/*
	realiza a venda de um mix !
*/
function compramix($message,$nivel , $valor,$query){

	$confibot = $GLOBALS[confibot];

	$chat_id = $message["chat"]["id"];
	$nome = $message['reply_to_message']['from']['first_name'];
	$idquery = $query['id'];
	$clientes = json_decode(file_get_contents("./usuarios.json") , true);
	$conf = json_decode(file_get_contents("./resource/conf.json") , true);

	$menu =  ['inline_keyboard' => [

		[]

	,]];



	$menu['inline_keyboard'][] = [['text'=>"🔚 Volta",'callback_data'=>"volta_loja"]];

	if (!$clientes[$chat_id]){
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "usuario sem registro , manda /start para se registra!!","show_alert"=> true,"cache_time" => 10)));
	}
	$user = $clientes[$chat_id];

	if ($user['saldo'] == 0){
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Vc nao tem saldo suficiente para realiza esta compra!\nCompre saldo com o {$confibot[userDono]}!","show_alert"=> true,"cache_time" => 10)));
	} 

	if ($valor > $user['saldo']){
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Vc nao tem saldo suficiente para realiza esta compra!\nCompre saldo com o {$confibot[userDono]}!","show_alert"=> true,"cache_time" => 10)));
	} 


	$cc = getmix($nivel);

	if (empty($cc)){
		bot("sendMessage" , array("chat_id" => $conf['dono'] , "text" => "base esta sem mix $nivel !!"));
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Desculpe , mas nao consegui pega esta cc.\nprovamente estou sem estoque!","show_alert"=> true,"cache_time" => 10)));
		
	}

	if (removesaldo($chat_id , $valor)){

		bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Foi Descontado $valor do seu saldo!! ","show_alert"=> false,"cache_time" => 10));

		$lista = explode("\n", $cc);
		foreach ($lista as  $cc) {
			// bot("sendMessage",array( "chat_id"=> $chat_id , "text" => $cc));
			$bin = substr(trim($cc), 0,6);

			$binchk = file_get_contents('https://bincheck.io/bin/'.$bin);

			$ban =  strtoupper(getstr($binchk,'<td style="text-align: left;">','</td>',1));
			$type = strtoupper(getstr($binchk,'style="text-align: left;">','</td>',3));
			$banco = strtoupper(getstr($binchk,'style="text-align: left;">','</td>',5));
			$pais = strtoupper(getstr($binchk,'style="text-align: left;">','</td>',8)); 
			$nivel = str_replace("\t", '', strtoupper(getstr($binchk,'style="text-align: left;">','</td>',4)));

			bot("sendMessage",array( "chat_id"=> $chat_id , "text" => $cc . " ".trim($ban)." ".trim($type)." ".trim($nivel)." ".trim($banco)." ".trim($pais).""));
		}

	
		salvacompra($cc,$chat_id,"mixs");
		bot("sendMessage",array( "chat_id"=> $chat_id , "text" => "*Compra realizada com sucesso*\n_Obs: problemas relata ao {$confibot[userDono]}!!\nVc pode ver esta compra no seu perfil!_","reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown',"reply_markup" =>$menu));

		exit();
	}else{
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Ocorreu um error interno , Tente novamente!","show_alert"=> false,"cache_time" => 10)));
	}

	
}



/*
	realiza a venda de ccs!!
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/

function compraccs($message , $query , $level , $idcc , $band){

	$confibot = $GLOBALS[confibot];
	$chat_id = $message["chat"]["id"];
	$nome = $message['reply_to_message']['from']['first_name'];
	$idquery = $query['id'];

	$clientes = json_decode(file_get_contents("./usuarios.json") , true);
	$conf = json_decode(file_get_contents("./resource/conf.json") , true);

	if (!$clientes[$chat_id]){
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "usuario sem registro , manda /start para se registra!!","show_alert"=> true,"cache_time" => 10)));
	}

	$user = $clientes[$chat_id];
	$country = $user['country'];
	$saldo = $clientes[$chat_id]['saldo'];
	$ccs = json_decode(file_get_contents("./ccs/{$country}/{$level}.json") , true);
	$valor = ($conf['price'][$level] ? $conf['price'][$level] : $conf['price']['default']);

	if ($user['saldo'] == 0){
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Vc nao tem saldo suficiente para realiza esta compra!\nCompre saldo com o {$confibot[userDono]}!","show_alert"=> true,"cache_time" => 10)));
	} 

	if ($valor > $user['saldo']){
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Vc nao tem saldo suficiente para realiza esta compra!\nCompre saldo com o {$confibot[userDono]}!","show_alert"=> true,"cache_time" => 10)));
	} 
	
	foreach ($ccs as $key => $dadoscc) {
		if ($key == $idcc){
			
			break;
		}
	}

	if (removesaldo($chat_id , $valor)){
		
		deletecc($chat_id , $idcc , $level);
		salvacompra($dadoscc , $chat_id , "ccs");

		bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Foi Descontado $valor do seu saldo!! ","show_alert"=> false,"cache_time" => 10));

		$clientes = json_decode(file_get_contents("./usuarios.json") , true);
		$saldo = $clientes[$chat_id]['saldo'];

		$result = json_decode(bot("getMe" , array("vel" => "")) , true);
		$userbot = $result['result']['username'];
		$gera1 = rand(100,999);
	    $gera2 = rand(100,999);
	    $gera3 = rand(100,999);
	    $gera4 = rand(10,99);

		$txt .= "✨*Detalhes da cc*\n";
		$txt .= "*💳cc: *_".$dadoscc['cc']."_\n";
		$txt .= "📆*mes / ano: *_" . $dadoscc['mes'] .'/'.$dadoscc['ano'] ."_\n";
		$txt .= "🔐*cvv: *_{$dadoscc[cvv]}_\n";
		$txt .= "🏳️*bandeira:* _$dadoscc[bandeira]_\n";
		$txt .= "💠*nivel:* _$dadoscc[nivel]_\n";
		$txt .= "⚜️*tipo:* _$dadoscc[tipo]_\n";
		$txt .= "🌍*CPF DONO:* `$gera1.$gera2.$gera3-$gera4`\n";
		$txt .= "⚠️*Seu saldo:* _{$saldo}_\n";

		$menu =  ['inline_keyboard' => [

			[["text" => "🔄 Compra novamente" , "url" => "http://telegram.me/$userbot?start=iae"]]

		,]];

		bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_markup" =>$menu,"reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown'));

		die;
	}else{
		bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Foi Descontado $valor do seu saldo!! ","show_alert"=> false,"cache_time" => 10));
		die;
	}

}

function altercard($message , $query , $type , $position , $level , $band){

	$confibot = $GLOBALS[confibot];


	$chat_id = $message["chat"]["id"];
	$nome = $message['reply_to_message']['from']['first_name'];
	$idquery = $query['id'];

	$clientes = json_decode(file_get_contents("./usuarios.json") , true);
	$conf = json_decode(file_get_contents("./resource/conf.json") , true);


	
	if (!$clientes[$chat_id]){
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "usuario sem registro , manda /start para se registra!!","show_alert"=> true,"cache_time" => 10)));
	}

	$user = $clientes[$chat_id];
	$country = $user['country'];
	$saldo = $clientes[$chat_id]['saldo'];
	$ccs = json_decode(file_get_contents("./ccs/{$country}/{$level}.json") , true);

	$cclista = []; 

	$buttons = [];

	foreach ($ccs as $key => $value) {
		if ($value['bandeira'] == $band){
			$value['idcc'] = $key;
			$cclista[] = $value;
		}
	}

	if ($type == "prox"){
		
		if ($cclista[ $position +1]){
			$postio4n = $position +1;
		}else{
			die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Não a próxima cc!","show_alert"=> false,"cache_time" => 10)));
		}

	}else{

		if ($cclista[ $position -1]){
			$postio4n = $position -1;
		}else{
			die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "Não a cc anterio!","show_alert"=> false,"cache_time" => 10)));
		}
	}

	$valor = ($conf['price'][$level] ? $conf['price'][$level] : $conf['price']['default']);

	$dadoscc = $cclista[$postio4n];
	$t = $postio4n +1;
	$txt = "🔎*Mostrando {$t} de ".sizeof($cclista)."*\n\n";
	$txt .= "✨*Detalhes da cc*\n";
	$bin = substr($dadoscc['cc'], 0,6);
	$txt .= "*💳cc: *_".$bin.'xxxxxxxxx'."_\n";
	$txt .= "📆*mes / ano: *_" . $dadoscc['mes'] .'/'.$dadoscc['ano'] ."_\n";
	$txt .= "🔐*cvv: *_xxx_\n";
	$txt .= "🏳️*bandeira:* _$dadoscc[bandeira]_\n";
	$txt .= "💠*nivel:* _$dadoscc[nivel]_\n";
	$txt .= "⚜️*tipo:* _$dadoscc[tipo]_\n";
	$txt .="\n💰*Valor*: $valor (saldo)\n";
	$txt .= "⚠️*Seu saldo:* _{$saldo}_\n";
	$menu =  ['inline_keyboard' => [

		[["text" => "💰Compra💰" , "callback_data" => "compraccs_{$level}_{$dadoscc[idcc]}_{$band}"]],
		[["text" => "<<" , "callback_data" => "altercard_ant_{$postio4n}_{$level}_{$band}"] , ["text" => ">>" , "callback_data" => "altercard_prox_{$postio4n}_{$level}_{$band}"]],
		[['text'=>"🔚 Volta",'callback_data'=>"ccun"]]

	,]];


	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_markup" =>$menu,"reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown'));


}

function viewcard($message , $query , $band , $level){

	$confibot = $GLOBALS[confibot];


	$chat_id = $message["chat"]["id"];
	$nome = $message['reply_to_message']['from']['first_name'];
	$idquery = $query['id'];

	$clientes = json_decode(file_get_contents("./usuarios.json") , true);
	$conf = json_decode(file_get_contents("./resource/conf.json") , true);

	
	if (!$clientes[$chat_id]){
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "usuario sem registro , manda /start para se registra!!","show_alert"=> true,"cache_time" => 10)));
	}

	$user = $clientes[$chat_id];
	$country = $user['country'];
	$saldo = $clientes[$chat_id]['saldo'];

	$ccs = json_decode(file_get_contents("./ccs/{$country}/{$level}.json") , true);

	$cclista = []; 

	$buttons = [];

	foreach ($ccs as $key => $value) {
		if ($value['bandeira'] == $band){
			$value['idcc'] = $key;
			$cclista[] = $value;
		}
	}


	$valor = ($conf['price'][$level] ? $conf['price'][$level] : $conf['price']['default']);

	$dadoscc = $cclista[0];
	$txt = "🔎*Mostrando 1 de ".sizeof($cclista)."*\n\n";
	$txt .= "✨*Detalhes da cc*\n";
	$bin = substr($dadoscc['cc'], 0,6);
	$txt .= "*💳cc: *_".$bin.'xxxxxxxxx'."_\n";
	$txt .= "📆*mes / ano: *_" . $dadoscc['mes'] .'/'.$dadoscc['ano'] ."_\n";
	$txt .= "🔐*cvv: *_xxx_\n";
	$txt .= "🏳️*bandeira:* _$dadoscc[bandeira]_\n";
	$txt .= "💠*nivel:* _$dadoscc[nivel]_\n";
	$txt .= "⚜️*tipo:* _$dadoscc[tipo]_\n";
	
	$txt .="\n💰*Valor*: $valor (saldo)\n";
	$txt .= "⚠️*Seu saldo:* _{$saldo}_\n";
	$menu =  ['inline_keyboard' => [

		[["text" => "💰Compra💰" , "callback_data" => "compraccs_{$level}_{$dadoscc[idcc]}_{$band}"]],
		[["text" => "<<" , "callback_data" => "altercard_ant_0_{$level}_{$band}"] , ["text" => ">>" , "callback_data" => "altercard_prox_0_{$level}_{$band}"]],
		[['text'=>"🔚 Volta",'callback_data'=>"ccun"]]

	,]];


	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_markup" =>$menu,"reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown'));
}

function compracc($message,$query,$level){

	$confibot = $GLOBALS[confibot];


	$chat_id = $message["chat"]["id"];
	$nome = $message['reply_to_message']['from']['first_name'];
	$idquery = $query['id'];

	$clientes = json_decode(file_get_contents("./usuarios.json") , true);
	$conf = json_decode(file_get_contents("./resource/conf.json") , true);

	$menu =  ['inline_keyboard' => [

		[]

	,]];

	$menu['inline_keyboard'][] = [['text'=>"🔚 Volta",'callback_data'=>"volta_loja"]];

	if (!$clientes[$chat_id]){
		die(bot("answerCallbackQuery",array("callback_query_id" => $idquery , "text" => "usuario sem registro , manda /start para se registra!!","show_alert"=> true,"cache_time" => 10)));
	}

	$user = $clientes[$chat_id];
	$country = $user['country'];
	
	$ccs = json_decode(file_get_contents("./ccs/{$country}/{$level}.json") , true);

	$band = [];
	$buttons = [];

	foreach ($ccs as $key => $value) {
		if (!in_array($value['bandeira'], $band)){
			$band[] = $value['bandeira'];
			$buttons[] = ["text" => $value['bandeira'] , "callback_data" => 'viewcard_'.$value['bandeira'].'_'.$level];
		}
	}

	
	$menu['inline_keyboard'] = array_chunk($buttons , 2);

	$menu['inline_keyboard'][] = [['text'=>"🔚 Volta",'callback_data'=>"ccun"]];

	$txt = "\n*✅nivel:* _{$level}_\n*💳 Escolha a bandeira:*";

	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_markup" =>$menu,"reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown'));

		
}


/*

	function loja 
	exibir menu loja virtual

*/
function loja($message){
	$chat_id = $message["chat"]["id"];
	$nome = $message['reply_to_message']['from']['first_name'];
	$menu =  ['inline_keyboard' => [

		[['text'=>"💳Compra cc's unitárias",'callback_data'=>"ccun"]],
		[['text'=>"💳 Compra Mix",'callback_data'=>"ccmix"] , ['text'=>"🔎Busca Bin",'callback_data'=>"search"]],
		[['text'=>"🔚 Volta",'callback_data'=>"volta_menu"]]

		,
	]];


	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => "*Ola $nome , Bem vindo (a)  a minha loja virtual! , aqui você pode compra ccs , saldo , mix e muito mas confira as opções abaixa:*","reply_markup" =>$menu,"reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown'));
	
}


/*

	function menu
	exibir menu inicial

*/

function menu($message){
	$chat_id = $message["chat"]["id"];
	$nome = $message['reply_to_message']['from']['first_name'];
	$idwel = $message['reply_to_message']['from']['id'];
	$conf = json_decode(file_get_contents("./resource/conf.json") , true);

	if ($conf['welcome'] != ""){
		$txt = $conf["welcome"];

		$txt = str_replace("{nome}", $nome, $txt);
		$txt = str_replace("{id}", $idwel, $txt);

	}else{
		$txt = "*Ola $nome , User meus comandos Abaixo para Interagir comigo !*";
	}


	$menu =  ['inline_keyboard' => [

		[['text'=>"🛒COMPRAR CCS🛒",'callback_data'=>"loja"]],[['text'=>"💰COMPRAR SALDO",'callback_data'=>"comprasaldo"]],[['text'=>"💎SUAS INFORMAÇOES💎",'callback_data'=>"menu_infos"]]

	,]];
	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => $txt,"reply_markup" =>$menu,"reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown'));
	
}


/*

	function ccn 
	exibir menu ccs 

*/


function ccun($message){
	$chat_id = $message["chat"]["id"];
	$nome = $message['reply_to_message']['from']['first_name'];


	$menu =  ['inline_keyboard' => [[], ]];

	$openprice = json_decode(file_get_contents("./resource/conf.json") , true);

	$users = json_decode(file_get_contents("./usuarios.json") , true);

	if (!$users[$chat_id]['country']){
		selectbase($message);
		die;
	}
	// selectbase($message);


	$ccs = [];
	$country = $users[$chat_id]['country'];
	$dir = './ccs/'.$country.'/';

	$itens = scandir($dir);
	
	if ($itens !== false) { 
		foreach ($itens as $item) { 
			$ccs[] =  explode(".", $item)[0];
		}
	}

	$levels = array_values(array_filter($ccs));


	$butoes = [];

	if (count($levels) == 0){
		$confibot = $GLOBALS[confibot];
		$menu['inline_keyboard'][] = [['text'=>"🔚 Volta",'callback_data'=>"volta_loja"]];
		bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => "*Ops, Estou sem estoque no momento , duvidas chame o* {$confibot[userDono]}","reply_markup" =>$menu,"reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown'));
		die();
	}
	$total = sizeof($ccs);
	$pesu = ($conf['price'][$value] ? $conf['price'][$value] : $conf['price']['default']);



	foreach ($levels as $value) {
		
		$butoes[] = ['text'=> "$value - $pesu",'callback_data'=>"compracc_{$value}"];
		
	}
	$butoes[] = ['text'=>"🔚 Volta",'callback_data'=>"volta_loja"];
	$butoes[] = ['text'=>"🌎 Altera pais",'callback_data'=>"selectbase"];

	$menu['inline_keyboard'] = array_chunk($butoes , 2);

	$confibot = $GLOBALS[confibot];

	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => "*💳Escolha o nivel:*","reply_markup" =>$menu,"reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown'));
	
}



/*

	function ccn 
	exibir menu mixs

*/


function ccmix($message){

	$confibot = $GLOBALS[confibot];


	$chat_id = $message["chat"]["id"];
	$nome = $message['reply_to_message']['from']['first_name'];


	$menu =  ['inline_keyboard' => [[], ]];

	$openccs = json_decode(file_get_contents("./resource/conf.json") , true);
	$mix = json_decode(file_get_contents("./mix.json") , true);


	if (count(array_filter($mix)) == 0){
		$menu['inline_keyboard'][] = [['text'=>"🔚 Volta",'callback_data'=>"volta_loja"]];
		bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => "Ops, Estou sem estoque no momento , duvidas chame o {$confibot[userDono]}","reply_markup" =>$menu,"reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown'));
		die();
	}


	$array = [];
	$tabela = '';

	foreach ($mix as $key => $value) {

		if ($openccs['pricemix'][$key]){
			$valor = $openccs['pricemix'][$key];
		}else{
			$valor = $openccs['pricemix']['default'];
		}

		$tabela .= "\n".'💳 Mix '.strtoupper($key).' --- '.$valor." (saldo)\n";
		$total = sizeof($mix[$key]);
		$array[] = ['text'=>"Mix $key - disponiveis ($total)",'callback_data'=>"compramix_{$key}_$valor"];
	}
	$add = array_chunk($array, 2);
	$menu['inline_keyboard'] = $add;
	$menu['inline_keyboard'][] = [['text'=>"🔚 Volta",'callback_data'=>"volta_loja"]];

	bot("editMessageText",array( "message_id" => $message['message_id'] , "chat_id"=> $chat_id , "text" => "Esta area e resevada para mix's , caso nao tenha o mix que vc estaja procurando entre em contato com o nosso vendedor: {$confibot[userDono]}!\n$tabela","reply_markup" =>$menu,"reply_to_message_id"=> $message['message_id'],"parse_mode" => 'Markdown'));
	
}