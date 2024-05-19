{ pkgs }: {
  deps = [
    pkgs.php82
    pkgs.php82Extensions.pdo
    pkgs.sqlite
  ];
}