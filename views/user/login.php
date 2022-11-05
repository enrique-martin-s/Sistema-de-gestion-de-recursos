    <div class="login-background">
      <div class="sidenav">
         <div class="login-main-text">
            <img src="/assets/images/escudo.png" alt="escudo celia viñas" style="width:100px ;">
            <h2>Gestor de recursos<br> Página de login</h2>
            <p>Haz login o registrate como usuario para acceder.</p>
            <?php
            if (isset($data["error"])) {
                echo "<div style='color: red'>".$data["error"]."</div>";
            }
            if (isset($data["info"])) {
                echo "<div style='color: blue'>".$data["info"]."</div>";
            }
            ?>
         </div>
      </div>
        <div class="main">
                <div class="col-md-6 col-sm-12">
                    <div class="login-form">
                            <form>
                                <div class="form-group">
                                    <label>Usuario</label>
                                    <input type="text" class="form-control" text' name='username' placeholder="Usuario">
                                </div>
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input type="password" class="form-control"  name='password' placeholder="Contraseña">
                                </div>
                                <button id="loginButton" type="button" class="btn btn-black">Login</button>
                                <button onclick="registerButton()" type="button" class="btn btn-secondary">Registro</button>
                            </form>
                    </div>
                </div>
            </div>
    </div>
      <script type="text/javascript">
        function loginButton (){
            console.log("login");
            window.location.href = "index.php?controller=UserController&action=processFormLogin&username="+document.forms[0].elements[0].value+"&password="+document.forms[0].elements[1].value;
        }
        function registerButton (){
            window.location.href = "index.php?controller=UserController&action=formAddUser";
        }
        document.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                loginButton();
            }
        });
        document.getElementById("loginButton").addEventListener("click", loginButton);
      </script>

</body>
</html