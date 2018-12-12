function closeWin(){
	self.close();
	$(opener.document).find(".openRecord").blur();
}

function historyInsert(seq, str) {
	if(str != "") {
		var insert = {};
		insert["param"] = { "refseq" : seq , "gubunColor" : "blue", "memo" : str};
		insert["table"] = "issue_history";
		ajax(insert,"/sub/historyInsert.php");
	} 
	alram();
}

function alram() {
	alert("수정되었습니다.");
	location.reload();
}
function emp(val) {
	var result = (val=="") ? "없음" : val;
	return result;
}