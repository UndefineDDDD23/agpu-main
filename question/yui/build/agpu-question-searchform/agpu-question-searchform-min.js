YUI.add("agpu-question-searchform",function(o,e){var n=".searchoptions";M.question=M.question||{},M.question.searchform={init:function(){o.delegate("change",this.option_changed,o.config.doc,n,this)},option_changed:function(o){o.target.getDOMNode().form.submit()}}},"@VERSION@",{requires:["base","node"]});