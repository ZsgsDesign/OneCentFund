#API说明
####请求地址：https://1cf.co/api/API名称
注：如果请求不成功，则不会返回任何内容(null)
注2：请开启cookies存储，并且在第一次传入时传入用户的loginid
##授权参数和Secret生成方式
sha1(API名称+"7d3cfe8c4ecbdad6539e0b8d50d91215"+时间)

|参数名|描述|类型|
|---|---|---|
|time|请求时间(格式和生成sha1用的格式一样即可)|time|
|secret|生成的sha1串|string|

##Getquestion 抽题
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

##Getanswer 答题
###传入参数
|参数名|描述|类型|
|---|---|---|
|ans|选项的ans代码|string|
###传出参数
|参数名|描述|类型|
|---|---|---|
|result|判断结果(0,1)|int|
|ans|正确答案|string|
|reward|连续答对题数|int|

##Verifyaccount 验证loginid有效性
###传入参数
|参数名|描述|类型|
|---|---|---|
|loginid|sha1(邮箱+"1cf.co"+密码md5)|string|
###传出参数
|参数名|描述|类型|
|---|---|---|
|result|有效性(0,1)|int|
|info|用户信息(无效loginid则为null)|array|

##Register 注册
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

##Checkin(未完成) 签到

##Getranklist 获取排行榜
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

##Getbases 获取题库
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

##Getgrantees 获取受众列表
###传入参数
无
###传出参数
返回一个长度为受众总数的数组，参数如下：

|参数名|描述|类型|
|---|---|---|
|gid|受众id|int|
|name|受众名|string|
|location|地点|string|
|general|简介|string|
|img|图片地址|string|
|sponsor|赞助方|string|
|target|目标积分|int|
|current|当前积分|int|
|status|是否完成(0,1)|int|
|rate|完成率(%)|float|
|count|参与人数|int|

##Getgranteeinfo 获取单个受众信息
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
|supervisor|监督方|string|
|supervisor_link|监督方链接|string|
|supervisor_img|监督方图片|string|
|supervisor_description|监督方描述|string|
|location|地点|string|
|general|简介|string|
|story|受众描述|string|
|img|受众图片|string|
|target|目标积分|int|
|current|当前积分|int|
|status|是否完成|int|
|link|tb链接|string|
|rate|完成度(%)|float|


##Modifyuserinfo 修改用户信息（不包括头像）
###传入参数
注：只需传入需要修改的内容

|参数名|描述|类型|
|---|---|---|
|name|昵称(可选)|string|
|sex|性别(可选)|int|
|pass|密码md5(可选)|string|
|real_name|真实姓名(可选)|string|
|tel|电话(可选)|string|
|qq|QQ号(可选)|string|
|weibo|微博(可选)|string|
|intro|自我介绍(可选)|string|
###传出参数
|参数名|描述|类型|
|---|---|---|
|result|修改成功的信息条数(相同视为未修改)|int|

##Changeavatar 更换头像
###传入参数
|参数名|描述|类型|
|---|---|---|
|avatar|头像图片的base64代码(包含文件头)|string|
###传出参数
|参数名|描述|类型|
|---|---|---|
|result|状态(0,1)|int|
|url|头像地址|string|