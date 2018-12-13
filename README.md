

[ThinkPHP 5.0 整合 WorkerMan 以及 GatewayWorker 在线多人聊天]
======================================================================



1、多人聊天室
http://xx.com/?s=chat/chat/index


启动服务 : 
cd public
sudo php server.php start
======================================================================



2、在线客服访问地址：
（客服登录）http://xx.com/admin/CustomerService/index (客服账号：yao  xiongxiong)
（游客访问）https://xx.com/admin/chats/index


启动服务 : 
cd public
sudo php server.php start
======================================================================




3、安装swoole扩展：
https://todarcy.com/2018/11/26/01-48/
======================================================================





4、nginx配置：

	server {
        listen       80;
        server_name  xx.com;
        error_log logs/xx.log;
        root   /html/xx/public;

        location / {
                index index.php index.html index.htm;
                try_files $uri $uri/ /index.php?$query_string;
                # 是否允许访问目录
                autoindex on;
                if (!-e $request_filename) {
                        rewrite ^/(.*)$ /index.php/$1 last;#隐藏index.php文件
                }
        }

        error_page   500 502 503 504  /50x.html;
        location = /50x.html {
            root   html;
        }

        location ~ ^(.+\.php)(.*)$ {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_split_path_info  ^(.+\.php)(/?.+)$;
            # 下面这个要求 /script 替换成 $document_root ，否则会出现 404 错误
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            fastcgi_param  PATH_INFO  $fastcgi_path_info;
            fastcgi_param  PATH_TRANSLATED  $document_root$fastcgi_path_info;
            include        fastcgi_params;
        }
    }



