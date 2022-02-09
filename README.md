# 唐诗查询系统（网页设计期末项目）

## 1、前言

​	嗯，对...是个网页设计期末项目，老师给的要求是实现一个查询系统。然后前一周写完了，这周想起来放在 github 上。因为项目工期比较赶，所以前端的页面就写得比较随意，有需要的同学自取吧。



## 2、简介

​	功能：查询页可根据诗名、作者名和诗句匹配包含关键字的诗。与服务器数据交互使用 ajax   方式，查询结果**分段加载**，内容随滚动条向下滑动而更新。点击单条查询结果可打开该首诗的详细信息页，包含完整诗句和作者简介。

​	技术栈：html + css + jQuery 搭建前端，后端服务器程序搭建使用 php，数据在 mysql 存储。

​	特点：

- 登录验证和访问权限控制
- 简单的 sql 防注入过滤设计
- 直接响应搜索框的文本输入，无需点击按钮



## 3、演示

​		项目演示地址：[律回彼境-唐诗信息在线查询](https://www.glowmem.com/projectsLab/poetryQuery/login)



## 4、配置使用

​	**如果你有使用该项目的需求，可以按照下面的步骤进行配置：**

### （1）创建数据库存入数据

​	**特别注意：由于唐诗诗文中生僻字字符编码问题，导出的备份文件无法正常还原。因此不提供数据库备份文件进行还原。请自行按以下操作添加数据。**

​	在 mysql 添加以下配置，避免在数据存储时出错。设置完成后重启 mysql 服务。

```text
# my.ini 配置：

[client]
# 设置mysql客户端默认字符集
default-character-set=utf8mb4
 
[mysqld]
# 服务端使用的字符集默认为8比特编码的latin1字符集
character-set-client-handshake = FALSE
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci 
init_connect='SET NAMES utf8mb4'
default-storage-engine=INNODB

[mysql]
default-character-set=utf8mb4
```

​	

​	按照以下配置新建表（表名、数据库名自定，无影响，但请将两个表建在一个数据库中）

​	唐诗数据表：

``` sql
CREATE TABLE `你的表名` (
  `id` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `title` varchar(130) COLLATE utf8mb4_bin NOT NULL,
  `author` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `paragraphs` mediumtext COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
```

​	唐朝诗人数据表：

```sql
CREATE TABLE `你的表名` (
  `id` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `desc` mediumtext COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

​	

​	将 `dataset/insert_author.php` 和 `dataset/insert_poetry.php` 中信息补充完整再执行：（前一个插入唐朝诗人信息，对应上面第二个表；另一个插入诗信息，对应上面第一个表）

```php
...
$dbhost = '';		// 连接主机
$dbuser = '';		// 用户
$dbpwd = '';		// 密码
$dbname = '';		// 数据库名
$dbtable = '';		// 表名
...
```

​	数据量较大，请耐心等待。



### （2）修改项目配置

​	根据你的实际情况和需求修改 `requirements/global.php` 中的全局常量，这些常量对应以下含义：

|     常量名     |            含义            |
| :------------: | :------------------------: |
|    `UNAME`     |       项目系统登录名       |
|     `UPWD`     |        项目系统密码        |
|  `LINK_HOST`   |       数据库连接主机       |
|   `DB_NAME`    |          数据库名          |
| `POETRY_TABLE` |       唐诗数据表表名       |
| `AUTHOR_TABLE` |     唐朝诗人数据表表名     |
|   `DB_USER`    | 用于登录查询的数据库用户名 |
|    `DB_PWD`    |      登录用户名的密码      |



### （3）webServer 配置

​	入口路由是：`login.php`。请将网站根目录配置到 `login.php` 所在目录。

​	其他配置根据自己使用的 webserver 的配置方法配置即可。



## 5、其他

### （1）服务器响应状态码

​	服务器响应 json 结果的 "status" 值。

​	在配置过程中出现错误，可通过状态码排查：

| 值    | 含义                             |
| ----- | -------------------------------- |
| `200` | 请求正常（已做出了正确的响应）   |
| `400` | 语法错误（请求参数为空）         |
| `403` | 拒绝请求（请求参数出现非法字段） |
| `500` | 内部错误（数据库连接失败）       |

