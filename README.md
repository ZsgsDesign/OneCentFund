#API说明
####请求地址：https://1cf.co/api/API名称
注：如果请求不成功，则不会返回任何内容(null)

##Getquestion
###传入参数
|参数名|描述|类型|
|---|---|---|
|cat|题库名（可选）|string|
###传出参数
|参数名|描述|类型|
|---|---|---|
|description|题目描述|string|
|opt1|A选项|string|
|opt2|B选项|string|
|opt3|C选项|string|
|opt4|D选项|string|
|ans1|A选项对应的ans代码（回答时用）|string|
|ans2|B选项对应的ans代码（回答时用）|string|
|ans3|C选项对应的ans代码（回答时用）|string|
|ans4|D选项对应的ans代码（回答时用）|string|

##Getanswer（未完成）
###传入参数
|参数名|描述|类型|
|---|---|---|
|ans|选项的ans代码|string|
###传出参数
|参数名|描述|类型|
|---|---|---|
|result|判断结果(0,1)|int|
|ans|正确答案|int|

##Verifyaccount
###传入参数
|参数名|描述|类型|
|---|---|---|
|loginid|sha1(邮箱+"1cf.co"+密码md5)|string|
###传出参数
|参数名|描述|类型|
|---|---|---|
|result|有效性(0,1)|int|
|info|用户信息(无效loginid则为null)|array|

##Register
###传入参数
|参数名|描述|类型|
|---|---|---|
|name|用户名|string|
|pass|密码md5|string|
|email|邮箱|string|
###传出参数
|参数名|描述|类型|
|---|---|---|
|result|结果(1,0)|int|
|info|username/email: 用户名/邮箱被占用(仅result=0时)|string|
|uid|新用户uid(result=1时)|int|

##Checkin(未完成)

##Getranklist
###传入参数
无
###传出参数
返回一个长度为20的数组，参数如下：

|参数名|描述|类型|
|---|---|---|
|uid|用户uid|int|
|name|用户名|string|
|avatar|头像地址|string|
|credit|爱心值|int|
|rank|排名数|int|

##Getbases
###传入参数
无
###传出参数
返回一个长度为题库总数的数组，参数如下：

|参数名|描述|类型|
|---|---|---|
|bid|题库id|int|
|cata|我不知道是啥|string|
|name|题库名|string|
|icon|我不知道是啥|string|
|background|我不知道是啥|string|
|num|题目数|string|
|date|最后更新日期|string|

##Getgrantees
###传入参数
无
###传出参数
返回一个长度为受众总数的数组，参数如下：

|参数名|描述|类型|
|---|---|---|
|gid|受众id|int|
|name|受众名|string|
|img|图片地址|string|
|sponsor|赞助方|string|
|target|目标积分|int|
|current|当前积分|int|
|status|是否完成(0,1)|int|
|rate|完成率(%)|int|

##Getgrantee
###传入参数
|参数名|描述|类型|
|---|---|---|
|gid|受众id|int|
###传出参数
|参数名|描述|类型|
|---|---|---|
|gid|受众id|int|
|name|受众名|string|
|sponsor|赞助方|string|
|sponsor_link|赞助方链接|string|
|sponsor_img|赞助方图片|string|
|sponsor_description|赞助方描述|string|
|story|受众描述|string|
|img|受众图片|string|
|target|目标积分|int|
|current|当前积分|int|
|status|是否完成|int|
|link|tb链接|string|
|rate|完成度(%)|int|