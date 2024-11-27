{ pkgs ? import <nixpkgs> { } }:
let
  php83 = pkgs.php83.buildEnv {
    extensions = ({ enabled, all }: enabled ++ (with all; [
      pdo
      pdo_mysql
      mysqli
      zip
      mbstring
      gd
      bcmath
      curl
      intl
      openssl
      sodium
    ]));
    extraConfig = ''
      memory_limit = -1
    '';
  };
in
pkgs.mkShell {
  buildInputs = with pkgs; [
    php83
    php83Packages.composer
  ];
  shellHook = ''
    echo "PHP $(php -v | head -n 1)"
    echo "Composer $(composer --version | head -n 1)"
    echo "Laravel development ready!"

    function clog() {
      local log_file="storage/logs/laravel.log"
      if [ -f "$log_file" ]; then
          truncate -s 0 "$log_file"
          echo "Truncated: $log_file"
      else
          echo "Log file does not exist: $log_file"
      fi
    }
  '';
}
