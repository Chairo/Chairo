String.prototype.isIDCard=function()
{
    var C15ToC18=function(c15) {
        var cId=c15.substring(0,6)+"19"+c15.substring(6,15);
        var strJiaoYan  =[  "1", "0", "X", "9", "8", "7", "6", "5", "4", "3", "2"];
        var intQuan =[7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
        var intTemp=0;
        for(i = 0; i < cId.length ; i++)
        intTemp +=  cId.substring(i, i + 1)  * intQuan[i];
        intTemp %= 11;
        cId+=strJiaoYan[intTemp];
        return cId;
    }
    var Is18IDCard=function(IDNum) {
        var aCity={11:"����",12:"���",13:"�ӱ�",14:"ɽ��",15:"���ɹ�",21:"����",22:"����",23:"������",31:"�Ϻ�",32:"����",33:"�㽭",34:"����",35:"����",36:"����",37:"ɽ��",41:"����",42:"����",43:"����",44:"�㶫",45:"����",46:"����",50:"����",51:"�Ĵ�",52:"����",53:"����",54:"����",61:"����",62:"����",63:"�ຣ",64:"����",65:"�½�",71:"̨��",81:"���",82:"����",91:"����"};

        var iSum=0,info="",sID=IDNum;
        if(!/^\d{17}(\d|x)$/i.test(sID)) {
            return false;
        }
        sID=sID.replace(/x$/i,"a");

        if(aCity[parseInt(sID.substr(0, 2))]==null) {
            return false;
        }

        var sBirthday=sID.substr(6,4)+"-"+Number(sID.substr(10,2))+"-"+Number(sID.substr(12,2));
        var d=new Date(sBirthday.replace(/-/g,"/"));

        if(sBirthday!=(d.getFullYear()+"-"+ (d.getMonth()+1) + "-" + d.getDate()))return false;

        for(var i=17; i>=0; i--) {
            iSum += (Math.pow(2, i) % 11) * parseInt(sID.charAt(17 - i), 11);
        }

        if(iSum%11!=1) {
            return false;
        }

        return true;
    }

    return this.length==15 ? Is18IDCard(C15ToC18(this)) : Is18IDCard(this);
}
