<?
	session_start();

	session_register("usuario");
	session_register("id_usuario");
	session_register("nivel");

	include("conexion.php");

	function quitar($mensaje){
		$mensaje = str_replace("<","<",$mensaje);
		$mensaje = str_replace(">",">",$mensaje);
		$mensaje = str_replace("\'","'",$mensaje);
		$mensaje = str_replace('\"',"'",$mensaje);
		$mensaje = str_replace('\\\\','"\"',$mensaje);
		return $mensaje;
	}

	if(trim($HTTP_POST_VARS["txtUsuario"]) != "" && trim($HTTP_POST_VARS["txtContrasenia"]) != ""){

		$nickN = quitar($HTTP_POST_VARS["txtUsuario"]);
		$passN = quitar($HTTP_POST_VARS["txtContrasenia"]);

		$result = mysql_query("SELECT * FROM usuario WHERE nombre='$nickN' AND contrasenia = '$passN'");
		if($row = mysql_fetch_array($result)){

			if($row["online"] == 0){
				//CREAMOS LA SESSION
				$_SESSION["usuario"]=$nickN;
				$_SESSION["id_usuario"]=$row["id"];
				$_SESSION["nivel"]=$row["cat_privilegios_id"];
				
				mysql_query("UPDATE usuario SET online = 1 WHERE nombre = '$nickN'");

				switch($row["cat_privilegios_id"]){
					case '1':
						$liga="../../administrador/index.php";
						break;
					case '2':
						$liga="../../coordinador/index.php";
						break;
					case '3':
						$liga="../../jurado/index.php";
						break;
					case '4':
						$liga="../../competidor/index.php";
						break;
					default:
						$liga="../../error.php";
				}

				header("Location: $liga");

			}else{
				echo "<html><script>alert('Ya ha iniciado sesi�n en otro equipo.');";
				echo "window.location.href='../../login.php?mensaje=inco';</script></html>";
			}
		}else{

			echo "<html><script>alert('Usuario o contrase�a incorrectos.');";
			echo "window.location.href='../../login.php?mensaje=noex';</script></html>";
		}

	}else{
		echo "<html><script>alert('Usuario no existente en la base de datos');";
		echo "window.location.href='../../login.php?mensaje=noex';</script></html>";
	}
?>