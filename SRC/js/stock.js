//
//仕入管理チェック
//
function fnStockEditCheck() {
	if (isLength(100, "担当", form.charge)) { return; }

	tmp = form.article.value;
	if (tmp.length == 0 || !tmp.trim()) {
		alert('物件名を入力してください');
		return;
	}
	if (isLength(100, "物件名", form.article)) { return; }
	if (isLength(100, "物件名（よみ）", form.articleFuri)) { return; }
	if (isLength(100, "部屋", form.room)) { return; }

	tmp = form.area.value;
	if (tmp.length > 0 && !tmp.match(/^([1-9][0-9]{0,2}|0)(\.[0-9][0-9]|\.[0-9])?$/)) {
		alert('面積は3桁以内（小数点以下2桁以内）の半角数字で入力してください');
		return;
	}
	if (isLength(100, "最寄駅", form.station)) { return; }
	if (isLength(100, "業者名", form.agent)) { return; }
	if (isLength(100, "店舗名", form.store)) { return; }
	if (isLength(100, "担当者", form.cover)) { return; }
	if (!fnYMDCheck("正しい内見日付", form.visitDT)) { return; }

	tmp = form.deskPrice.value;
	if (tmp.length > 5 || tmp.match(/[^0-9]+/)) {
		alert('机上金額は5桁以内の半角数字で入力してください');
		return;
	}

	tmp = form.vendorPrice.value;
	if (tmp.length > 5 || tmp.match(/[^0-9]+/)) {
		alert('売主希望金額は5桁以内の半角数字で入力してください');
		return;
	}
	if (isLength(1000, "備考", form.note)) { return; }
	if (confirm('この内容で登録します。よろしいですか？')) {
		form.act.value = 'stockEditComplete';
		form.submit();
	}
}



function fnStockDeleteCheck(no) {
	if (confirm('削除します。よろしいですか？')) {
		form.stockNo.value = no;
		form.act.value = 'stockDelete';
		form.submit();
	}
}



//
//仕入管理一括削除用チェックボックス全選択
//
function fnStockListDeleteAllCheck() {
	if (!document.form.delStock) {
		// 検索結果が0件の場合は何もしない
		return;
	}

	if (document.form.delStock.length) {
		// 検索結果が複数レコードの場合
		for (count = 0; count < document.form.delStock.length; count++) {
			document.form.delStock[count].checked = document.form.delStockAll.checked;
		}
	} else {
		// 検索結果が１件の場合
		document.form.delStock.checked = document.form.delStockAll.checked;
	}
}



//
// 仕入管理一括削除
//
function fnStockListDeleteCheck() {
	// 削除対象のStockNo受け渡し用
	var stockList = "";

	form.delStockList.value = "";

	if (document.form.delStock.length) {
		// 検索結果が複数レコードの場合
		for (count = 0; count < document.form.delStock.length; count++) {
			if (document.form.delStock[count].checked) {
				// 複数件選択されている場合には「,」で区切る
				if (stockList != "") {
					stockList += ",";
				}
				stockList += document.form.delStock[count].value;
			}
		}
	} else {
		// 検索結果が１件の場合
		if (document.form.delStock.checked) {
			stockList += document.form.delStock.value;
		}
	}

	if (stockList == "") {
		alert('削除対象が未選択です。');
		return;
	}

	if (confirm('削除します。よろしいですか？')) {
		form.delStockList.value = stockList;
		form.act.value = 'stockListDelete';
		form.submit();
	}
}
