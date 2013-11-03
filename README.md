初期設置
======================
composer update

jenkinsのjob設定
---------------------------
・参考URL http://d.hatena.ne.jp/lifegood/20121214/p1
・ジョブのコピー(開発環境にて)
jenkins.xml の<customWorkspace></customWorkspace>を自分のパスに変更
<pre>
mkdir /var/lib/jenkins/jobs/eventhub
cp jenkins.xml /var/lib/jenkins/jobs/eventhub/config.xml
chown jenkins:jenkins -R /var/lib/jenkins/jobs/eventhub/
service jenkins restart
</pre>


マイグレーション
======================
vendor/bin/cake -app cakephp/EventHub/ Migrations.migration run all


テストの実行
======================
<pre>
$ phing build
</pre>

・個別に実行
<pre>
$ vendor/bin/cake test app -app cakephp/EventHub/ All
$ vendor/bin/cake test app -app cakephp/EventHub/ AllController
$ vendor/bin/cake test app -app cakephp/EventHub/ AllModel
$ vendor/bin/cake test app -app cakephp/EventHub/ AllConsole
$ vendor/bin/cake test app -app cakephp/EventHub/ Console/Command/Task/EventImport
$ vendor/bin/cake test app -app cakephp/EventHub/ Model/Event
$ vendor/bin/cake test app -app cakephp/EventHub/ Lib/ApiConvert
</pre>




データの取得
--------------------------
<pre>
$ vendor/bin/cake -app cakephp/EventHub/ event
$ vendor/bin/cake -app cakephp/EventHub/ provider
</pre>

データの取得(cron)
--------------------------
<pre>
$ vendor/bin/cake -app cakephp/EventHub/ event cron
</pre>

