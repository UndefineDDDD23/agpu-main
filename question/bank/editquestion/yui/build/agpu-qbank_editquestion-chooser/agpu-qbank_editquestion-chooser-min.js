YUI.add("agpu-qbank_editquestion-chooser",function(n,e){var s="div.createnewquestion",o="div.createnewquestion form",r="div.chooserdialoguebody",u="div.choosertitle";function i(){i.superclass.constructor.apply(this,arguments)}n.extend(i,M.core.chooserdialogue,{initializer:function(){n.all(o).each(function(e){"chooserform"!==e.get("id")&&(e.on("submit",this.displayQuestionChooser,this),e.one("button").set("disabled",!1))},this)},displayQuestionChooser:function(e){var o,i=n.one(s+" "+r),t=n.one(s+" "+u);null===this.container&&(this.setup_chooser_dialogue(i,t,{}),this.prepare_chooser()),i=e.target.ancestor("form",!0),o=this.container.one("form"),t=i.all('input[type="hidden"]'),o.all("input.customfield").remove(),t.each(function(e){o.appendChild(e.cloneNode()).removeAttribute("id").addClass("customfield")}),this.display_chooser(e)}},{NAME:"questionChooser"}),M.question=M.question||{},M.question.init_chooser=function(e){return new i(e)}},"@VERSION@",{requires:["agpu-core-chooserdialogue"]});