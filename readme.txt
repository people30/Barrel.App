配置手順


データベース

1. phpMyAdmin を開きます。
2. データベース barrel_app を照合順序 utf8mb4_unicode_ci で作成します。
3. データベース barrel_stories を照合順序 utf8mb4_unicode_ci で作成します。
4. ユーザ barrel を任意のパスワードで作成し、ワイルドカード (ユーザ名_%) に該当するデータベースにすべての特権を与えます。


WordPress

1. barrel_stories ディレクトリを c:\xampp\htdocs に移動します。
2. 続きよろしく


Web サイト

1.  barrel_app ディレクトリを c:\xampp\htdocs に移動します。
2.  .env ファイルを開きます。
5.  GMAP_KEY に Google Map API のキーを記入します。これは無くても動作しますが地図は表示されません。
6.  DB_DATABASE にデータベース名を記入します。
7.  DB_USERNAME にユーザ名を記入します。
8.  DB_PASSWORD にパスワードを記入します。
9.  ファイルを保存し閉じます。
10. initialize.bat を実行します。

以上です。