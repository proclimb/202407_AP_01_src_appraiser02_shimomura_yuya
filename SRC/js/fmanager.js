//
//ファイルマネージャー物件管理チェック
//
function fnFManagerEditCheck() {
	if (LengthCheck("物件名", form.article)) { return; }
	if (isLength(50, "物件名", form.name)) { return; }
	if (isLength(50, "部屋", form.room)) { return; }
	if (isLength(100, "備考", form.note)) { return; }
	if (confirm('この内容で登録します。よろしいですか？')) {
		form.act.value = 'fManagerEditComplete';
		form.submit();
	}
}

function fnFManagerDeleteCheck(no) {
	if (confirm('削除します。よろしいですか？')) {
		form.fMNo.value = no;
		form.act.value = 'fManagerDelete';
		form.submit();
	}
}



//
//ファイルマネージャー書類チェック
//
function fnFManagerViewEditCheck() {
	if (isLength(100, "備考", form.note)) { return; }
	tmp = form.pdfFile.value;
	if (tmp.slice(-4) != '.pdf' && tmp.slice(-4) != '.PDF') {
		alert('PDFファイルを指定してください');
		return;
	}

	if (confirm('この内容で登録します。よろしいですか？')) {
		form.act.value = 'fManagerViewEditComplete';
		form.submit();
	}
}



function fnFManagerViewDeleteCheck(no) {
	if (confirm('削除します。よろしいですか？')) {
		form.pdfNo.value = no;
		form.act.value = 'fManagerViewDelete';
		form.submit();
	}
}
