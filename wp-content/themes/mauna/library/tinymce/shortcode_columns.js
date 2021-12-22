(function() {
    tinymce.PluginManager.add( 'columns', function( editor, url ) {
        // Add Button to Visual Editor Toolbar
        editor.addButton('columns', {
            title: 'Columns',
            icon: 'table',
            type: 'menubutton',
            onclick: function(event) {
                editor.on('BeforeSetContent', function(event){
                    var content = event.content.replace( /\[column([^\]]*)\]([^\]]*)\[\/column\]/g, '\&nbsp;');
                    event.content = content;

                });
                editor.insertContent(event.control.state.data.value);
            },
            menu: [
                {
                    text:'2 Columns', 
                    value: '<div class="columns small-12 large-6 mauna-columns start-row"><p>[column][/column]</p></div><div class="columns small-12 large-6 mauna-columns end-row"><p>[column][/column]</p></div><br>',
                },
                {
                    text:'3 Columns', 
                    value: '<div class="columns small-12 large-4 mauna-columns start-row"><p>[column][/column]</p></div><div class="columns small-12 large-4 mauna-columns"><p>[column][/column]</p></div><div class="columns small-12 large-4 mauna-columns end-row"><p>[column][/column]</p></div><br>',
                },
                {
                    text:'4 Columns', 
                    value: '<div class="columns small-12 large-3 mauna-columns start-row"><p>[column][/column]</p></div><div class="columns small-12 large-3 mauna-columns"><p>[column][/column]</p></div><div class="columns small-12 large-3 mauna-columns"><p>[column][/column]</p></div><div class="columns small-12 large-3 mauna-columns end-row"><p>[column][/column]</p></div><br>',
                },
            ]
        });
       
    });
})();
