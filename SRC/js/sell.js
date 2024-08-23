//
//売主物件チェック
//
function fnSellEditCheck() {
	if (LengthCheck("日付", form.searchDT)) { return; }
	if (!fnYMDCheck("正しい日付", form.searchDT)) { return; }
	if (LengthCheck("物件名", form.article)) { return; }
	if (isLength(100, "物件名", form.article)) { return; }
	if (LengthCheck("住所", form.address)) { return; }
	if (isLength(100, "住所", form.address)) { return; }
	if (isLength(100, "駅", form.station)) { return; }
	if (LengthCheck("徒歩", form.foot)) { return; }
	if (isNumericLength(2, "徒歩", form.foot)) { return; }
	if (LengthCheck("築年", form.years)) { return; }
	if (isNumericLength(4, "築年", form.years)) { return; }
	if (LengthCheck("階数", form.floor)) { return; }
	if (isNumericLength(2, "階数", form.floor)) { return; }
	if (LengthCheck("面積", form.area)) { return; }
	if (AreaCheck("専有面積", form.area)) { return; }
	if (LengthCheck("売主", form.seller)) { return; }
	if (isLength(100, "売主", form.seller)) { return; }
	if (LengthCheck("価格", form.price)) { return; }
	if (isNumericLength(5, "価格", form.price)) { return; }
	if (isLength(200, "備考", form.note)) { return; }
	if (confirm('この内容で登録します。よろしいですか？')) {
		form.act.value = 'sellEditComplete';
		form.submit();
	}
}



function fnSellDeleteCheck(no, nm) {
	if (confirm('「' + nm + '」を削除します。よろしいですか？')) {
		form.sellNo.value = no;
		form.act.value = 'sellDelete';
		form.submit();
	}
}
