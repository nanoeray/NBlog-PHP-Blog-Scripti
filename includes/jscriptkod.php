<script type="text/javascript">
function Goster(Id)
{
	if(document.getElementById("L1").checked)
		document.getElementById(Id).style.display = "";
	else
		document.getElementById(Id).style.display = "none";	
}

function showlayer(layer){ 
    var myLayer=document.getElementById(layer); 
    if(myLayer.style.display=="none" || myLayer.style.display==""){ 
        myLayer.style.display="block"; 
    } else { 
        myLayer.style.display="none"; 
        } 
}
$("[data-toggle=tooltip]").tooltip();
</script>