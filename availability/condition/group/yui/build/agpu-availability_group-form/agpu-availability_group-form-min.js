YUI.add("agpu-availability_group-form",function(r,i){M.availability_group=M.availability_group||{},M.availability_group.form=r.Object(M.core_availability.plugin),M.availability_group.form.groups=null,M.availability_group.form.initInner=function(i){this.groups=i},M.availability_group.form.getNode=function(i){for(var a,e,t,l,o='<label><span class="pe-3">'+M.util.get_string("title","availability_group")+'</span> <span class="availability-group"><select name="id" class="custom-select"><option value="choose">'+M.util.get_string("choosedots","agpu")+'</option><option value="any">'+M.util.get_string("anygroup","availability_group")+"</option>",n=0;n<this.groups.length;n++)o+='<option value="'+(a=this.groups[n]).id+'" data-visibility="'+a.visibility+'">'+a.name+"</option>";return(t=(e=r.Node.create('<span class="d-flex flex-wrap align-items-center">'+(o+="</select></span></label>")+"</span>")).one("select[name=id]")).on("change",function(i){var a=i.target.get("value"),a=i.target.one("option[value="+a+"]").get("dataset").visibility,i=0<a?"availability:privateRuleSet":"availability:privateRuleUnset";e.fire(i,{plugin:"group"})}),i.creating===undefined&&(i.id!==undefined?(l=t.one("option[value="+i.id+"]"))&&(t.set("value",""+i.id),0<l.get("dataset").visibility&&window.setTimeout(function(){e.fire("availability:privateRuleSet",{plugin:"group"})},0)):i.id===undefined&&e.one("select[name=id]").set("value","any")),M.availability_group.form.addedEvents||(M.availability_group.form.addedEvents=!0,r.one(".availability-field").delegate("change",function(){M.core_availability.form.update()},".availability_group select")),e},M.availability_group.form.fillValue=function(i,a){a=a.one("select[name=id]").get("value");"choose"===a?i.id="choose":"any"!==a&&(i.id=parseInt(a,10))},M.availability_group.form.fillErrors=function(i,a){var e={};this.fillValue(e,a),e.id&&"choose"===e.id&&i.push("availability_group:error_selectgroup")}},"@VERSION@",{requires:["base","node","event","agpu-core_availability-form"]});