[TOC]

------

# Tecnologias utilizadas

Neste trabalho, foram usadas diversas tecnologias para a obtenção de um resultado final limpo, funcional e agradável à sua utilização.

- Na parte de front-end, foram usadas tecnologias como **html**, **css**, **javascript**. 
- Na parte de back-end, essencialmente foi utilizado **php** para a comunicação com a base de dados.
- A nível da base de dados, foi usado **mysql**, uma vez que a sua comunicação com **php** é bastante facilitada.

(Acrescentar explicação sobre mysql, no que falamos no wpp).

# Desenvolvimento da aplicação

## Base de dados

Para iniciar o desenvolvimento da aplicação, comecei por construir um modelo de dados utilizando o **Visual** **Paradigm**. Aqui foram identificadas as principais entidades que fariam parte deste modelo e seriam necessárias para o restante processo de desenvolvimento da aplicação. Dada a complexidade dos dados, este processo teria que ser bem feito, de modo a que no futuro não houvesse necessidade de o alterar novamente.

![img](https://cdn.discordapp.com/attachments/1011219445152231495/1013102887850758225/unknown.png)

### Entidades

1. **Role**: A chave primária desta tabela é o id da role, um número que identifica cada role específica e em seguida um roleName, que tal como indica o nome, apresenta uma breve descrição de 1 ou 2 palavras sobre de que se trata a role em questão (admin, manager, client). 
2. **User**: A chave primária desta tabela é o id novamente, que identificará cada utilizador por um único número incrementado automaticamente. Além disso são guardadas outras informações sobre o mesmo, tais como, o username, a password e uma chave estrangeira referente à role do mesmo, que terá de existir na tabela anterior.
3. **Client**: A chave primária desta tabela é o id do client, incrementado automaticamente. Contém ainda um name, que se refere ao nome do Client, podendo o mesmo ter uma extensão de até 55 caracteres e ainda uma chave estrangeira para a tabela user, referindo-se ao id do user.
4. **Records**: Por fim, na tabela de records, são guardados todos os registos de cada cliente, daí a associação representada entre client e records, de 1 para 0 ou mais, podendo o mesmo então possuir 0 ou mais registos associados a si. Esta tabela possui então tal como as outras um id como chave primária, uma data do registo, o valor solar e eólico e uma chave estrangeira, para identificar a que cliente pertencem tais registos.

### Criação da base de dados

Para a criação da base de dados e construção das tabelas foi usado o seguinte script:

```mysql
ALTER TABLE Client DROP FOREIGN KEY FKClient606918;
ALTER TABLE Records DROP FOREIGN KEY FKRecords133403;
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS Client;
DROP TABLE IF EXISTS Records;
CREATE TABLE `User` (
                        Id       int(10) NOT NULL AUTO_INCREMENT,
                        username varchar(55) NOT NULL,
                        password varchar(55) NOT NULL,
                        PRIMARY KEY (Id));
CREATE TABLE Client (
                        id int(10) NOT NULL AUTO_INCREMENT,
                        name     varchar(55) NOT NULL,
                        UserId   int(10) NOT NULL,
                        PRIMARY KEY (id));
CREATE TABLE Records (
                         Id             int(10) NOT NULL AUTO_INCREMENT,
                         RecordDate     varchar(55) NOT NULL,
                         Solar          double NOT NULL,
                         Eolic          int(10) NOT NULL,
                         ClientId int(10) NOT NULL,
                         PRIMARY KEY (Id));
ALTER TABLE Client ADD CONSTRAINT FKClient606918 FOREIGN KEY (UserId) REFERENCES `User` (Id);
ALTER TABLE Records ADD CONSTRAINT FKRecords133403 FOREIGN KEY (ClientId) REFERENCES Client (id);
```

## Front-end

Para a UI, foi utilizada a framework **Bootstrap**, com vista à obtenção de um visual moderno e adaptado aos padrões correntes dos websites de última geração.

#### Páginas

Existem **5** páginas principais, com as quais o utilizador tem contacto:

> 1. Login
>
>    ![image-20220828155103079](C:\Users\almei\AppData\Roaming\Typora\typora-user-images\image-20220828155103079.png)
>
> 2. Dashboard
>
>    ![image-20220828155230459](C:\Users\almei\AppData\Roaming\Typora\typora-user-images\image-20220828155230459.png)
>
>    3. Graphs
>
>    ![image-20220828155410032](C:\Users\almei\AppData\Roaming\Typora\typora-user-images\image-20220828155410032.png)
>
>    4. Chart
>
>    ![image-20220828155518989](C:\Users\almei\AppData\Roaming\Typora\typora-user-images\image-20220828155518989.png)
>
>    5. Production Control
>
>    ![image-20220828155623284](C:\Users\almei\AppData\Roaming\Typora\typora-user-images\image-20220828155623284.png)

#### Flow de utilização

1. Inicialmente, é necessário o utilizador fazer login. Para isto o mesmo deve ter uma role de admin ou manager, pois são os únicos autorizados a entrar no website.

   ![1](D:\Users\almei\Desktop\docs\1.gif)

2. Entrando corretamente, o utilizador terá acesso à dashboard. Aqui o mesmo pode ver o número de registos existentes na base de dados, o cliente selecionado e o número de clientes existentes na base de dados. Abaixo destes dados encontra-se uma tabela de clientes, onde mostra todos os clientes existentes na base de dados. Os mesmos podem ser editados, eliminados ou selecionados. Além disso existe ainda uma função para adicionar clientes.

   ![2](D:\Users\almei\Desktop\docs\2.gif)

3. Na parte dos gráficos, serão apresentados gráficos com os dados do cliente selecionado. Inicialmente é necessário escolher a prioridade (solar ou eólica) e em seguida inserir o ponto de injeção. Os valores poderão ser todos mostrados, ou apenas os selecionados. O gráfico pode ainda ser exportado para svg, csv ou png. O zoom é também uma funcionalidade, podendo o mesmo ser feito até onde o utilizador queira e retirado apenas com o clique de um botão. Abaixo do gráfico, encontram-se alguns cálculos de médias, usando os dados mostrados no gráfico.

   ![3](D:\Users\almei\Desktop\docs\3.gif)

4. Por fim, existe a página de controlo de produção, onde podem ser pesquisados e observados todos os dados da base de dados.

   ![4](D:\Users\almei\Desktop\docs\4.gif)

## Código

### Conexão à base de dados

Inicialmente, foi criado um ficheiro chamado "db.php", onde é feita a conexão à base de dados.

```
<?php
    $servername='localhost';
    $username='root';
    $password='';
    $dbname = "mtxsolar";
    $conn=mysqli_connect($servername,$username,$password,"$dbname");
    if(!$conn){
        die('Could not Connect MySql Server:' .mysql_error());
    }
?>
```

O mesmo é eficaz uma vez que noutros blocos de código , quando é necessário usar dados da base de dados, não é necessário escrever o código inerente à conexão, bastando apenas incluir esta linha:

```
// include mysql database configuration file
include_once 'db.php';
```

### Página de Login

Na página de login, compreendemos a necessidade de fazer com que apenas utilizadores autorizados e presentes na base de dados, entrem no website. Para isso cada utilizador deve inserir os seus dados no campo de username e no campo da password e no fim clicar no botão de login.

Para ser possível obter os dados, os campos de texto e o botão de login foram colocados dentro de uma form, com o método post.

```
<form method="POST" action="#" class="signin-form">
    <div class="form-group mt-3">
        <input name="username" type="text" class="form-control" required>
        <label class="form-control-placeholder" for="username">Username</label>
    </div>
    <div class="form-group">
        <input name="password" id="password-field" type="password"
               class="form-control" required>
        <label class="form-control-placeholder" for="password">Password</label>
        <span toggle="#password-field"
              class="fa fa-fw fa-eye field-icon toggle-password"></span>
    </div>
    <div class="form-group">
        <button name="submit" type="submit"
                class="form-control btn btn-primary rounded submit px-3">
            Sign In
        </button>
    </div>
    <div class="form-group d-md-flex">
        <div class="w-50 text-left">
            <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                <input type="checkbox" checked>
                <span class="checkmark"></span>
            </label>
        </div>
    </div>
</form>
```

Além disso, nesta página de login (ficheiro index.php), inicialmente é iniciada uma sessão, que permitirá passar dados entre as diferentes páginas, enquanto o utilizador estiver com a sua sessão iniciada.

```
<?php
    // Start the session
    session_start();
?>
```

Logo abaixo da tag que fecha o código html, encontra-se um bloco de código em php que começa por incluir a conexão à base de dados e em seguida recolhe os dados introduzidos nos campos de username e password para utilizar como variáveis. 

```
include_once 'db.php';

$_SESSION['clientName'] = null;
$_SESSION['clientId'] = null;

if (isset($_POST['username'])) {
    $uname = $_POST['username'];
    $password = $_POST['password'];

    $_SESSION["username"] = $uname;
```

É então feito um query à base de dados para verificar se o utilizador e a password que foram introduzidos coincidem com alguma linha da base de dados.

```
$sql = "select * from user where username='" . $uname . "'AND password='" . $password . "' limit 1";
```

Se o número de resultados desta pesquisa for igual a 1, significa que o utilizador foi encontrado e a sua password está correta, logo resta saber qual o seu cargo para em seguida prosseguir para a próxima página. Os dados do seu cargo, são guardados na sessão com o index de role uma vez que serão úteis em seguida.

```
if ($num_rows == 1) {
    if (strcmp($uname,"admin")===0) {
        $_SESSION["role"] = "admin";
    }
    else if (strcmp($uname,"manager")===0) {
        $_SESSION["role"] = "manager";
    }
    else {
        $_SESSION["role"] = "client";
    }
    echo "<br>" . "You Have Successfully Logged In";
    ?>
    <script type="application/javascript">
        window.location = "home.php"
    </script>
    <?php
} else {
    echo "<br>" . "You Have Entered Incorrect Password";
}
```

### Cabeçalho

Em todas as páginas exceto login, passa a existir um cabeçalho, que possui um icon a representar o utilizador e contendo o seu username obtido através da variável de sessão, bem como a sua role:

```
<?php
    echo $_SESSION["username"]
?>
<?php
	echo mb_strtoupper($_SESSION["role"])
?>
```

### Dashboard

Após um login bem sucedido, o utilizador encontra-se na página da dashboard, ficheiro "home.php". Tal como anteriormente esta página e as que serão abordadas em seguida, iniciam uma sessão para obterem todas os mesmos dados partilhados através da mesma.

```
<?php
    // Start the session
    session_start();
?>
```

#### Cartões

Existem então 3 cartões no início da página.

- O primeiro refere-se ao **número total de registos**, número esse obtido através de um query à base de dados, pedindo o número total de linhas existentes na tabela de registos.

  ```
  <?php
      // include mysql database configuration file
      include_once 'db.php';
  
      $sql = "select * from records";
      $result1 = mysqli_query($conn, $sql);
      $num_rows1 = mysqli_num_rows($result1);
  
      echo $num_rows1;
  ?>
  ```

- O segundo **identifica o cliente selecionado** na tabela abaixo. Caso a variável de sessão clientName não possua valor, significa que nenhum cliente foi selecionado, caso contrário é mostrado o cliente selecionado. 

  ```
  <?php
      if (isset($_SESSION["clientName"])) {
          echo "<h6>{$_SESSION['clientName']}</h6>";
      } else {
          echo '<h6>No customer selected</h6>';
      }
  ?>
  ```

- Por fim, o terceiro cartão parecido com o primeiro, **mostra o total de clientes existentes na base de dados**, fazendo um query desta vez à tabela de clientes, para obter o número total de linhas da mesma, equivalente ao número de clientes.

  ```
  <?php
      // include mysql database configuration file
      include_once 'db.php';
  
      $sql = "select * from client";
      $result1 = mysqli_query($conn, $sql);
      $num_rows1 = mysqli_num_rows($result1);
  
      echo $num_rows1;
  ?>
  ```

#### Tabela de clientes

Abaixo dos cartões existe uma tabela de clientes, que está diretamente sincronizada com a base de dados. Isso significa que se um cliente foi editado, apagado ou inserido na base de dados, ao fazer refresh da página, o mesmo é mostrado na tabela.

Esta tabela tem o propósito de selecionar e editar clientes. Existem 2 permissões distintas nesse aspeto. O <u>administrador</u> pode **selecionar**, **editar**, **eliminar** e **adicionar clientes**, enquanto que um <u>manager</u> pode apenas **selecionar clientes**. 

Esta parte foi bastante fácil de filtrar, uma vez que uma **condição if** determina se esses botões são adicionados ou não:

```
if (strcmp($_SESSION["role"], "admin") === 0) {

    echo "<a href='update.php?clientId={$row['id']}&clientName={$row['name']}' type='button' 			class='btn btn-success'><i class='bi bi-pen-fill me-1'></i>Update</a>
    		<button data-bs-toggle='modal' data-bs-target='#verticalycentered1' 	type='button' class='btn btn-danger'><i class='bi bi-person-dash-fill me-1'></i>Remove</button>";
    		
}
```

##### Adicionar Clientes

Para adicionar clientes, existe um botão dedicado, que mais uma vez apenas está presente se o utilizador for administrador.

```
<?php
    if (strcmp($_SESSION["role"], "admin") === 0) {
        echo "<button data-bs-toggle='modal' data-bs-target='#verticalycentered' type='button'
        class='btn btn-primary'><i class='bi bi-plus-circle me-1'></i>Add Customer
</button> <br>
<br>";
    }
?>
```

Olhando apenas para o botão o mesmo possui dois parâmetros importantes:

```
data-bs-toggle='modal' data-bs-target='#verticalycentered'
```

Estes fazem com que ao ser clicado, o botão abra um componente novo chamado de modal, com o id de "verticalycentered". Este diálogo que se abre, possui um campo onde se introduz obrigatoriamente o nome do cliente e abaixo do mesmo um campo para se fazer o upload de um ficheiro que deverá estar no formato csv, para depois ser lido e introduzido na base de dados.

```
<div class="modal fade" id="verticalycentered" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="insert.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input name="name" type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-2 col-form-label">File
                            Upload</label>
                        <div class="col-sm-10">
                            <input name="file" class="form-control" type="file"
                                   accept=".csv" id="formFile" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <button name="submit" type="submit"
                                class="form-control btn btn-primary rounded submit px-3">
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
```

Tal como o login, este diálogo trata-se de uma form, que no fim é submetida e redirecionada para um ficheiro php diferente, para tratar do "trabalho duro" de inserir os dados.

```
<form action="insert.php" method="POST">
```

No ficheiro "insert.php" encontramos uma conexão à base de dados, bem como a obtenção do nome do cliente e o ficheiro inserido anteriormente.

```
include_once 'db.php';

if (!empty($_POST['name'])) {

    $name = $_POST['name'];
    $username = mb_strtolower($_POST['name']);
    $password = mb_strtolower($_POST['name']) . '123';
    $file = $_POST['file'];
```

Em seguida, começa-se por introduzir na base de dados um user que será o utilizador associado ao cliente.

```
$query = "insert into user(username, password) VALUES ('$username','$password')";
```

Em seguida, após corrido o query e inserido o user, é obtido o id do user criado para se utilizar na criação do cliente.

```
$query1 = "select id from user where username='$username'";

$run1 = mysqli_query($conn, $query1);

if ($run1) {
    while ($row = mysqli_fetch_array($run1)) {
        $userId = $row['id'];

        $query2 = "insert into client(name, UserId) VALUES ('$name','$userId')";
```

Após o cliente estar registado, o ficheiro csv é aberto e as suas linhas são percorridas num ciclo while e adicionadas na base de dados, associadas ao cliente. 

```
try{
    while (($getData = fgetcsv($csvFile, 100000,";")) !== FALSE) {
        // Get row data

        if (strlen($getData[0])>0){
            $date = $getData[0];
            $solar = rtrim(sprintf('%f', $getData[1]), "0");
            $eolic=str_replace(' ', '', $getData[2]);
            $solar=str_replace(' ', '', $solar);
            $run4 = mysqli_query($conn, "INSERT INTO records (RecordDate, solar, eolic, ClientId) VALUES ('$date','$solar','$eolic','$cliId')");
        }
    }
}catch (Exception $e){}
fclose($csvFile);
```

No fim deste processo todo a página é atualizada, podendo-se observar uma atualização nos cartões de registos e clientes. Se o mesmo não acontecer, significa que o ficheiro inserido não estava com a disposição correta de colunas.

```
?>
<script type="application/javascript">
    window.location = "home.php"
</script>
<?php
```

##### Editar um cliente

Para editar um cliente (tendo as permissões necessárias) é preciso clicar no botão update, que se situa na linha do cliente que se quer editar, na coluna operations. Ao clicar neste botão, o utilizador é reencaminhado para uma sub página chamada de Update Customer.

```
<a href='update.php?clientId={$row['id']}&clientName={$row['name']}' type='button' class='btn btn-success'><i class='bi bi-pen-fill me-1'></i>Update</a>
```

O ficheiro 'update.php' é essa página. O mesmo é constituído por uma form parecida com a que foi apresentada anteriormente na parte de adicionar um cliente. Assim o utilizador tem a possibilidade de editar o nome do cliente ou o ficheiro de registos ou ambos.

```
<form action="update1.php" method="POST">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <?php
                        $id = $_GET['clientId'];
                        $name = $_GET['clientName'];
                        $_SESSION['editId'] = $id;
                        echo "<input placeholder=$name name='name' type='text' class='form-control'>"
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputNumber" class="col-sm-2 col-form-label">File
                    Upload</label>
                <div class="col-sm-10">
                    <input name="file" class="form-control" type="file"
                           accept=".csv" id="formFile">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="form-group">
                <button name="submit" type="submit"
                        class="form-control btn btn-primary rounded submit px-3">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</form>
```

Quando as alterações são submetidas, clicando no botão que diz Confirm, os dados são enviados para um ficheiro php, para serem tratados corretamente, "update1.php".

Anteriormente foi guardado numa variável de sessão "editId", o id do cliente que estava a ser editado. Esse dado, bem como o nome do cliente e o ficheiro são tidos em conta nesta página "update1.php".

O nome é atualizado facilmente através do query:

```
$query = "
update client
set name='$name'
where id=$id
";
```

Já em relação aos registos, a abordagem optada foi **apagar todos os registos anteriormente adicionados relativos a esse cliente** (se existirem) e só **depois disso adicionar os novos registos**, como foi feito na parte de inserir o cliente.

```
$query = "
    delete from records
    where ClientId=$id;
";
```

```
while (($getData = fgetcsv($csvFile, 100000, ";")) !== FALSE) {
    // Get row data
    $date = $getData[0];

    $solar = $getData[1];

    $eolic = $getData[2];

    $run4 = mysqli_query($conn, "INSERT INTO records (RecordDate, solar, eolic, ClientId) VALUES ('$date','$solar','$eolic','$id')");
}
fclose($csvFile);
```

##### Eliminar um cliente

Para eliminar um cliente, é necessário clicar no botão identificado como "Remove" contido em cada linha da tabela de clientes. Este botão quando clicado abre um diálogo que avisa que o cliente será removido e se o utilizador tem a certeza disso. Confirmando a sua decisão, o cliente é apagado e a página atualiza não mostrando mais esse cliente ou os seus registos.

A abertura do diálogo é conseguida através de algo parecido com o diálogo de adicionar um cliente referido anteriormente.

```
<button data-bs-toggle='modal' data-bs-target='#verticalycentered1' type='button' class='btn btn-danger'><i class='bi bi-person-dash-fill me-1'></i>Remove</button>
```

Neste caso, é feita uma referência a outra div "verticalycentered1" muito parecida com a "verticalycentered". A mesma corresponde a uma form essencialmente, contendo o texto um botão de confirmar e um de cancelar, que fecha o diálogo e volta para a página anterior.

O botão de confirmar funciona como um submit da form e envia o id do cliente e o id de user do mesmo como parâmetro para o ficheiro "delete.php".

```
<a href='delete.php?deleteid={$row['id']}&userid={$row['UserId']}' type='button' class='btn btn-danger'><i class='bi bi-person-dash-fill me-1'></i>Remove</a>
```

Neste ficheiro, esses dados são utilizados para encontrar todos os registos desse cliente, o seu user e o client, apagando esses dados pela ordem correta, de modo a não causar erros na base de dados, por causa das chaves estrangeiras entre eles.

**Ordem correta: Records > Client > User**.

```
if (isset($_GET['deleteid'])){
    $id=$_GET['deleteid'];
    $userId=$_GET['userid'];
    $query = "delete from records where ClientId=$id";
    $run = mysqli_query($conn, $query);
    if ($run) {
        $query1 = "delete from client where id=$id";
        $run1 = mysqli_query($conn, $query1);
        if ($run1){
            $query2 = "delete from user where id=$userId";
            $run2 = mysqli_query($conn, $query2);
            if ($run2){
                ?>
                <script type="application/javascript">
                    window.location = "home.php"
                </script>
                <?php
            }
        }
    }
}
```

##### Selecionar um cliente

Para selecionar um cliente, função essa partilhada pelo manager e administrador, basta clicar no botão azul select ao lado direito do cliente que se pretende selecionar.

```
<a href='select.php?clientId={$row['id']}&clientName={$row['name']}' type='button' class='btn btn-primary'><i class='bi bi-mouse-fill me-1'></i>Select</a>
```

Este botão redireciona as atenções para o ficheiro "select.php", enviando o id do cliente e o seu nome. Aqui as variáveis de sessão do clientId e clientName são alteradas para os valores passados por parâmetro e retorna-se à página anterior. O cartão de cliente selecionado é então atualizado, observando-se a mudança desejada.

```
<?php
    session_start();
    $id = $_GET['clientId'];
    $name = $_GET['clientName'];
    $_SESSION['clientName'] = $name;
    $_SESSION['clientId'] = $id;
?>
    <script type="application/javascript">
        window.location = "home.php"
    </script>
<?php
?>
```

### Graphs

Nesta página é apresentada uma representação gráfica dos dados inseridos e calculados, bem como alguns cartões com outros cálculos feitos.

Para começar, é necessário ter selecionado um cliente na dashboard, caso contrário este processo não será possível, dado que esta análise se refere a um cliente só. Não existindo cliente selecionado aparece uma mensagem informativa do mesmo, através do código seguinte. Na condição if, é verificado se existe um cliente selecionado, caso contrário irá "cair" no else, mostrando esta mensagem.

```
else {
        echo '<div class="col-xxl-4 col-md-6">
    <div class="card info-card revenue-card">
        <div class="card-body">
            <h5 class="card-title">No Customer Selected</h5>

            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="ps-3">
                    <h6>
                    No customer selected
                    </h6>
                    <a href="home.php" class="text-muted small pt-2 ps-1">Select one of the customer first</a>
                </div>
            </div>
        </div>

    </div>
</div><!-- End Selected Client Card -->';
    }
```

Existindo um cliente selecionado,

```
if (isset($_SESSION['clientId'])) {
```

é apresentada uma form, pedindo para inserir alguns parâmetros:

- A prioridade, solar ou eólica.

```
<select name="priority" class="form-select" aria-label="Default select example" required>
    <option selected value="Solar">Solar</option>
    <option value="Eolic">Eolic</option>
</select>
```

- O ponto de injeção em kW, valor esse que não pode ser menos que 0.

```
<div class="row mb-3">
    <label for="inputNumber" class="col-sm-2 col-form-label">Injection point <span style="font-weight: bold">(kW)</span></label>
    <div class="col-sm-10">
        <input min="0" name="injection" step="0.01" type="number" class="form-control" required>
    </div>
</div>
```

- E um botão **Confirm**, que submete a form.

```
<div class="col-sm-10">
    <button type="submit" class="btn btn-primary">Confirm</button>
</div>
```

Este botão por sua vez, sendo do tipo "submit", irá encaminhar o utilizador para a página indicada no parâmetro action da form, a página "chart.php":

```
<form action="chart.php" method="POST">
```

#### Chart

##### Recolha de dados e cálculos

Nesta página será mostrados gráficos e alguns dados calculados, usando os registos do utilizador selecionado anteriormente.

Para isso no início do documento "chart.php" existe um bloco em php que começa por recolher dados da form anterior, como o ponto de injeção selecionado e a prioridade. Além disso utiliza a variável de sessão clientId, referente ao cliente selecionado, para recolher da base de dados todos os registos desse cliente. O mesmo é conseguido através deste query:

```
$query1 = "select RecordDate, Solar, Eolic from records where ClientId={$_SESSION['clientId']}";
```

Recolhendo todos os registos do cliente, chega a hora de trabalhar esses dados e preencher arrays com os cálculos realizados, para depois mostrar nos gráficos.

São inicializados os arrays destinados a agrupar esses valores, bem como variáveis necessárias para guardar o somatório dos valores para calcular a média:

```
$dates = [];
$solar = [];
$eolic = [];
$totalProduction = [];
$injectedPower = [];
$surplus = [];
$solarSurplus = [];
$eolicSurplus = [];
$surplusPerc = [];
$solarSurplusPerc = [];
$eolicSurplusPerc = [];

$sumTotalSurplus = 0;
$sumSolarSurplus = 0;
$sumEolicSurplus = 0;

$sumTotalProduction = 0;
$sumTotalSolar = 0;
$sumTotalEolic = 0;

$averageTotalSurplus = 0;
$averageSolarSurplus = 0;
$averageEolicSurplus = 0;
```

Após inicializadas as variáveis, num ciclo while, os registos são iterados e por cada um são calculados valores como a Produção total, potência injetada, excedentes...

Estes cálculos são possíveis, graças à classe Power, contida no ficheiro "power.php". Esta classe possui 4 atributos, o valor solar, o eólico, o ponto de injeção e o modo.

```
class Power
{
    public $solar;
    public $eolic;
    public $pontoInjeccao;
    public $modo;
```

Possui ainda um construtor, que corrige valores solares e eólicos negativos, para 0.

```
function __construct() {
    if ($this->solar<0){
        $this->solar=0;
    }
    if ($this->eolic<0){
        $this->eolic=0;
    }
}
```

Abaixo do construtor encontram-se as funções responsáveis pelos cálculos:

```
public function Total()
public function PotenciaI()
public function Excedente()
public function Excedentesolar()
public function Excedenteeolic()
public function Excedenteper()
public function Excedentepersolar()
public function Excedentepereolic()
```

Estas funções são as usadas dentro do ciclo while que percorre os registos:

```
$totalProduction[] = round($power->Total(),2);
$injectedPower[] = round($power->PotenciaI(),2);
$surplus[] = round($power->Excedente(),2) ;
$solarSurplus[] = round($power->Excedentesolar(),2);
$eolicSurplus[] = round($power->Excedenteeolic(),2);
$surplusPerc[] = round($power->Excedenteper(),2);
$solarSurplusPerc[] = round($power->Excedentepersolar(),2);
$eolicSurplusPerc[] = round($power->Excedentepereolic(),2);


$sumSolarSurplus += $power->Excedentesolar();
$sumEolicSurplus += $power->Excedenteeolic();
$sumTotalSurplus += $power->Excedente();

$sumTotalSolar += $power->solar;
$sumTotalEolic += $power->eolic;
$sumTotalProduction += $power->Total();
```

Por fim os arrays são convertidos para um formato reconhecido pela livraria responsável por construir o gráfico:

```
$dates = implode(',', $dates);
$solar = implode(',', $solar);
$eolic = implode(',', $eolic);
$totalProduction = implode(',', $totalProduction);
$injectedPower = implode(',', $injectedPower);
$surplus = implode(',', $surplus);
$solarSurplus = implode(',', $solarSurplus);
$eolicSurplus = implode(',', $eolicSurplus);
$surplusPerc = implode(',', $surplusPerc);
$solarSurplusPerc = implode(',', $solarSurplusPerc);
$eolicSurplusPerc = implode(',', $eolicSurplusPerc);
```

E são calculadas as médias, que serão depois mostradas nos cartões:

```
$averageTotalSurplus = round(($sumTotalSurplus/$sumTotalProduction)*100,2);
$averageSolarSurplus = round(($sumSolarSurplus/$sumTotalSolar)*100,2);
$averageEolicSurplus = round(($sumEolicSurplus/$sumTotalEolic)*100,2);
```

##### Gráfico

Para construir o gráfico, foi usada uma livraria em Javascript, chamada de **ApexCharts**, permitindo a mesma construir gráficos modernos e facilitar o tratamento de dados e a sua visualização. A mesma conta já com ferramentas embutidas como zoom no gráfico, o download do mesmo em formatos como csv, svg e pdf. Além disso é possível especificar o tipo de dados, facilitando por exemplo neste caso, o eixo dos x, por serem datas, é possível visualizar os meses, os dias, as horas, minutos, segundos (...) de acordo com as preferências do utilizador.

O gráfico é inicializado da seguinte forma:

```
const chart = new ApexCharts(document.querySelector("#lineChart"), {
```

E em seguida vão sendo definidos os argumentos. O primeiro refere-se às series, que na prática são as linhas que farão parte do gráfico. Aqui são introduzidos os arrays recolhidos anteriormente, com o seu título, duma forma bastante facilitada.

```
series: [
    {
        name: "Solar",
        data: [
            <?=
                $solar
                ?>
        ]
    },
    {
        name: "Eolic",
        data: [
            <?=
                $eolic
                ?>
        ]
    },
    {
        name: "Total Production",
        data: [
            <?=
                $totalProduction
                ?>
        ]
    },
    {
        name: "Injected Power",
        data: [
            <?=
                $injectedPower
                ?>
        ]
    },
    {
        name: "Total Surplus",
        data: [
            <?=
                $surplus
                ?>
        ]
    },
    {
        name: "Solar Surplus",
        data: [
            <?=
                $solarSurplus
                ?>
        ]
    },
    {
        name: "Eolic Surplus",
        data: [
            <?=
                $eolicSurplus
                ?>
        ]
    },
    {
        name: "Surplus Percentage",
        data: [
            <?=
                $surplusPerc
                ?>
        ]
    },
    {
        name: "Solar Surplus Percentage",
        data: [
            <?=
                $solarSurplusPerc
                ?>
        ]
    },
    {
        name: "Eolic Surplus Percentage",
        data: [
            <?=
                $eolicSurplusPerc
                ?>
        ]
    },
],
```

Abaixo dos dados, são definidas algumas configurações como o tipo de gráfico, a ativação ou desativação do zoom, algumas informações sobre a exportação do mesmo nos formatos referidos anteriormente, as cores dos gráficos e o tipo de dados dos eixos x e y.

Por fim, a linha mais importante:

```
chart.render();
```

Permite que o gráfico seja renderizado, e apresentado ao utilizador. Dada a complexidade do mesmo, quanto maior for o volume dos dados, mais lento é o seu carregamento, infelizmente não há grande contorno de otimização em relação a isso, contudo, após carregado possui uma experiência fluída e responsiva.

##### Médias

As médias apresentadas são relativas ao excedente total, solar e eólico anual e as mesmas surgem logo abaixo do gráfico, em cartões idênticos aos que apareciam na dashboard. Neste caso, não é preciso fazer nada de complexo nesta fase do código, dado que as mesmas já foram calculadas no início do documento, basta "imprimir" as variáveis nos cartões formatados pelo html e css.

```
<!-- Total Card -->
<div class="col-xxl-4 col-md-6">
    <div class="card info-card">
        <div class="card-body">
            <h5 class="card-title">Total Surplus <span>| %</span></h5>

            <div class="d-flex align-items-center">
                <div style="background-color: #ffdfdf" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i style="color: #d61c4e" class="bi bi-gem"></i>
                </div>
                <div class="ps-3">
                    <h6>
                        <?=
                            $averageTotalSurplus
                        ?>
                    </h6>
                </div>
            </div>
        </div>

    </div>
</div><!-- End Total Card -->

<!-- Solar Card -->
<div class="col-xxl-4 col-md-6">
    <div class="card info-card sales-card">
        <div class="card-body">
            <h5 class="card-title">Solar Surplus <span>| %</span></h5>

            <div class="d-flex align-items-center">
                <div style="background-color: #fff5df" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i style="color: #FAC213" class="bi bi-sun-fill"></i>
                </div>
                <div class="ps-3">
                    <h6>
                        <?=
                            $averageSolarSurplus
                        ?>
                    </h6>
                </div>
            </div>
        </div>

    </div>
</div><!-- End Solar Card -->

<!-- Eolic Card -->
<div class="col-xxl-4 col-md-6">
    <div class="card info-card sales-card">
        <div class="card-body">
            <h5 class="card-title">Eolic Surplus <span>| %</span></h5>

            <div class="d-flex align-items-center">
                <div style="background-color: #ffecdf" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i style="color: #F77E21" class="bi bi-wind"></i>
                </div>
                <div class="ps-3">
                    <h6>
                        <?=
                            $averageEolicSurplus
                        ?>
                    </h6>
                </div>
            </div>
        </div>

    </div>
</div><!-- End Eolic Card -->
```

### Production Control

Nesta última página do website, são mostrados, numa tabela de dados, todos os registos dos clientes existentes na base de dados. Para isso foi utilizada uma tabela de dados que já possui uma barra de pesquisar e um sistema de divisão dos dados em páginas incluída no pacote **Bootstrap**.

Caso exista um cliente selecionado na dashboard, apenas serão mostrados os registos do mesmo. Caso contrário serão mostrados os dados de todos os clientes existentes. O mesmo é conseguido através da seguinte condição e query's:

```
if (isset($_SESSION['clientId'])) {
    $query1 = "select Id, RecordDate, Solar, Eolic, ClientId from records where ClientId={$_SESSION['clientId']}";
}else {
    $query1 = "select Id, RecordDate, Solar, Eolic, ClientId from records";
}
```

Após o query ser "corrido", os parâmetros das linhas de tabela da base de dados, são recolhidos num ciclo while:

```
while ($row = mysqli_fetch_array($run1)) {
    $recordId = $row['Id'];
    $recordDate = $row['RecordDate'];
    $solar = $row['Solar'];
    $eolic = $row['Eolic'];
    $clientId = $row['ClientId'];
```

Em seguida é procurado o nome do cliente que detém esses dados, para os mostrar na tabela:

```
$query2 = "select * from client where id='$clientId'";
$run2 = mysqli_query($conn, $query2);

if ($run2){
    while ($row = mysqli_fetch_array($run2)) {
        $clientName = $row['name'];
    }
```

Por fim, são criadas as linhas da tabela html, para que sejam mostrados os dados:

```
echo "
<tr>
    <td>{$clientName}</td>
    <td>{$clientId}</td>
    <td>{$recordDate}</td>
    <td>{$solar}</td>
    <td>{$eolic}</td>
    <td>{$recordId}</td>
</tr>
";
```

O resultado final é uma tabela super rápida a ser renderizada, pesquisável e ordenável em qualquer parâmetro desejado e sempre atualizada!
