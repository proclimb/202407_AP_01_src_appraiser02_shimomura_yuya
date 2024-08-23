//
//業者一覧チェック
//
function fnTradeEditCheck() {
	tmp = form.name.value;
	if (tmp.length == 0) {
		alert('業者名を入力してください');
		return;
	}
	if (isLength(100, "業者名", form.name)) { return; }
	if (isLength(100, "業者名（よみ）", form.nameFuri)) { return; }
	if (isLength(100, "支店名", form.branch)) { return; }
	if (isLength(100, "支店名（よみ）", form.branchFuri)) { return; }
	tmp = form.zip.value;
	if (tmp.length > 0 && !tmp.match(/^\d{3}(\s*|-)\d{4}$/)) {
		alert("正しい郵便番号(***-**** 又は ******* )で\n入力してください");
		return;
	}
	if (isLength(10, "住所（都道府県）", form.prefecture)) { return; }
	if (isLength(100, "住所1（市区町村名）", form.address1)) { return; }
	if (isLength(100, "住所2（番地・ビル名）", form.address2)) { return; }
	if (isLength(100, "TEL", form.tel)) { return; }
	if (isLength(100, "FAX", form.fax)) { return; }
	if (isLength(100, "携帯電話", form.mobile)) { return; }

	if (confirm('この内容で登録します。よろしいですか？')) {
		form.act.value = 'tradeEditComplete';
		form.submit();
	}
}



function fnTradeDeleteCheck(no) {
	if (confirm('削除します。よろしいですか？')) {
		form.tradeNo.value = no;
		form.act.value = 'tradeDelete';
		form.submit();
	}
}
