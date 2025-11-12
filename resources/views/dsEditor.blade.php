@extends('layouts.app')

@section('content')

 <style>
    #txDocumentEditorContainer {
        width: 1000px;
        height: 600px;
        display: inline-block;
        position: relative;
    }
</style>

<div class="container">
	<h4 class="fw-bold">DS Editor</h4>
	<div class="mt-4">
		<h2>DocumentServices.DocumentEditor</h2>

        <div id="txDocumentEditorContainer"></div>
	</div>
</div>

<script>
window.addEventListener("load", function () {
    TXTextControl.init({
        containerID: "txDocumentEditorContainer",
        serviceURL: "https://trial.dsserver.io",
        authSettings: {
            clientId: "dsserver.SSuRW0A72nysHKbCcgGs5lhO0RyrwW2U",
            clientSecret: "tvGdZkzjcmrXI3FXUOihP1YdeLqeXbWj"
        },
        editMode: true // ✅ ensures the document is editable
    });

    // use the JavaScript API
    // https://docs.textcontrol.com/47c66f67/
    TXTextControl.addEventListener("textControlLoaded", function() {
        var sel = TXTextControl.selection;
        sel.setText("Welcome to DS Server", function() {
            sel.setStart(11);
            sel.setLength(9);
            sel.setBold(true);
            sel.setFontSize(30);
        });
    });
});
</script>
@endsection