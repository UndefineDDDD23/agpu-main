YUI.add("agpu-mod_quiz-modform",function(e,i){var t=function(){t.superclass.constructor.apply(this,arguments)};e.extend(t,e.Base,{repaginateCheckbox:null,qppSelect:null,qppInitialValue:0,initializer:function(){this.repaginateCheckbox=e.one("#id_repaginatenow"),this.repaginateCheckbox&&(this.qppSelect=e.one("#id_questionsperpage"),this.qppInitialValue=this.qppSelect.get("value"),this.qppSelect.on("change",this.qppChanged,this))},qppChanged:function(){e.later(50,this,function(){this.repaginateCheckbox.get("disabled")||this.repaginateCheckbox.set("checked",this.qppSelect.get("value")!==this.qppInitialValue)})}}),M.mod_quiz=M.mod_quiz||{},M.mod_quiz.modform=M.mod_quiz.modform||new t,M.mod_quiz.modform.init=function(){return new t}},"@VERSION@",{requires:["base","node","event"]});