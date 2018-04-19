<?php
	$JsonFile = file_get_contents("data-1.json");
	$Contents = json_decode($JsonFile, true);

	$Info=array();
	foreach ($Contents as $Content)
	{
		$Info[]=$Content;
	}	
	//var_dump($Info);
	if(isset($_GET['jsoncallback']) && !empty($_GET['jsoncallback']))
	{
		$array=array();
		if(isset($_GET['ChargeSection']) && !empty($_GET['ChargeSection']))
		{
			$Ciudad=$_GET["Ciudad"];
			$Tipo=$_GET["Tipo"];
			$P=explode(";", $_GET['Precio']);
			foreach ($Info as $Content)
			{
				$PrecioT=str_replace("$", '', $Content["Precio"]);
				$PrecioT=str_replace(",", '', $PrecioT);
				$Precio=$PrecioT;
				if(empty($Tipo))
				{
					if($Content["Ciudad"]==$Ciudad && $Precio>=$P[0] && $Precio<=$P[1])
					{
						$array[$Content['Id']]=array(
							'Direccion'=>$Content["Direccion"],
							'Ciudad'=>$Content["Ciudad"],
							'Telefono'=>$Content["Telefono"],
							'Codigo_Postal'=>$Content["Codigo_Postal"],
							'Tipo'=>$Content["Tipo"],
							'Precio'=>$Content["Precio"]
						);
					}
				}
				else
				{
					if($Content["Ciudad"]==$Ciudad && $Content["Tipo"]==$Tipo && $Precio>=$P[0] && $Precio<=$P[1])
					{
						$array[$Content['Id']]=array(
							'Direccion'=>$Content["Direccion"],
							'Ciudad'=>$Content["Ciudad"],
							'Telefono'=>$Content["Telefono"],
							'Codigo_Postal'=>$Content["Codigo_Postal"],
							'Tipo'=>$Content["Tipo"],
							'Precio'=>$Content["Precio"]
						);
					}
				}
			}
		}
		if(isset($_GET['ChargeAll']) && !empty($_GET['ChargeAll']))
		{
			foreach ($Info as $Content)
			{
				$array[$Content['Id']]=array(
					'Direccion'=>$Content["Direccion"],
					'Ciudad'=>$Content["Ciudad"],
					'Telefono'=>$Content["Telefono"],
					'Codigo_Postal'=>$Content["Codigo_Postal"],
					'Tipo'=>$Content["Tipo"],
					'Precio'=>$Content["Precio"]
				);
			}
		}
		if(isset($_GET['CargarCity']) && !empty($_GET['CargarCity']))
		{
			$Ciudades=array();
			$Tipos=array();
			foreach ($Info as $Content)
			{
				if (!in_array($Content['Ciudad'], $Ciudades))
				{
    				$Ciudades[]=$Content['Ciudad'];
				}
				if (!in_array($Content['Tipo'], $Tipos))
				{
    				$Tipos[]=$Content['Tipo'];
				}

			}
			sort($Ciudades);
			sort($Tipos);
			$array['Ciudades']=$Ciudades;
			$array['Tipos']=$Tipos;
		}
		echo $_GET['jsoncallback'].'('.json_encode($array).')';
	}
?>