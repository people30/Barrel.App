Barrel.App 配置手順


データベース

1. phpMyAdmin を開きます。
2. データベース barrel_app を照合順序 utf8mb4_unicode_ci で作成します。
3. データベース barrel_stories を照合順序 utf8mb4_unicode_ci で作成します。
4. ユーザ barrel を任意のパスワードで作成し、ワイルドカード (ユーザ名_%) に該当するデータベースにすべての特権を与えます。


WordPress

1. WordPress のファイルは持ってないので誰か書いてください


Web サイト

1. エクスプローラでプロジェクトのディレクトリを開きます。
1. .env ファイルを開きます。
2. APP_URL にルート URL を記入します。これはフロント コントローラ (/public/index.php) がトップページに来るような URL です。 
   例えば c:\xampp\htdocs\barrel-app に Web サイトを配置した場合は http://localhost/barrel-app/public/ です。
3. WP_URL に WordPress のルート URL を記入します。これは無くても動作しますが酒蔵詳細ページに記事が表示されません。
4. GMAP_KEY に Google Map API のキーを記入します。これは無くても動作しますが地図は表示されません。
4. DB_DATABASE にデータベース名を記入します。
5. DB_USERNAME にユーザ名を記入します。
6. DB_PASSWORD にパスワードを記入します。
7. ファイルを保存し閉じます。
8. initialize.bat を実行します。

以上です。