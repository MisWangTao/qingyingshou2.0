export const normalTime = time => {
    if (time && !isNaN(Number(time))) {
        let oDate = new Date();
        
        oDate.setTime(time);
        let y = oDate.getFullYear();
        let m = oDate.getMonth() + 1;
        let d = oDate.getDate();
        
        return y + '-' + m + '-' + d;
    }
}
export const numberFormat = number => {
    let n = parseFloat(number).toFixed(2);
    let re = /(\d{1,3})(?=(\d{3})+(?:\.))/g;
    return n.replace(re, "$1,");
}
export const echopaymethod = paymeid => {
    let payme = ''
    switch (paymeid){
        case '1' :
            payme =  '现金'
            break
        case '2' :
            payme = '支票'
            break
        case '3' :
            payme = '银行转账'
            break
        default :
            payme = '其他'
            break
    }
    return payme
}