<html>
<body>
<form action="formulario.php" method="post">
    <input type="text" name="nome" placeholder="nome:">
    <input type="email" name="email" placeholder="email:">
    <input type="text" name="telefone" placeholder="Telefone:">
    <input type="text" name="mensagem" placeholder="mensagem:">
    <input type="submit" value="enviar email">
</form>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script>
    $(document).ready(function(){
        $('form').submit(function(){
            $.ajax({
                type:'post',
                url:'formulario.php',
                data:$(this).serialize(),
                success:function(result){
                    console.log("sucesso");
                    console.log(result);
                },error:function(result){
                    console.log("erro ");
                    console.log(result);
                }
            });
            return false;
        });
    });

</script>
</body>
</html>