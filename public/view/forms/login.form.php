<?PHP
$login_form = new Form;
$login = $login_form->create('#', 'login', Null, "login_form", "POST")
           ->input("text", "u_name",Null,"enter your username")
           ->label("Username:")
           ->input("password", "pword",Null)
           ->label("Password:")
           ->input("hidden", "token")
           ->input("submit", "login","Login")
           ->label(" ")
           ->build();