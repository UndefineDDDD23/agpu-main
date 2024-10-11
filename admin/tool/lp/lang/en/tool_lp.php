<?php
// This file is part of agpu - http://agpu.org/
//
// agpu is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// agpu is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with agpu.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for component 'tool_lp', language 'en'
 *
 * @package    tool_lp
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['actions'] = 'Actions';
$string['activities'] = 'Activities';
$string['addcohorts'] = 'Add cohorts';
$string['addcohortstosync'] = 'Add cohorts to sync';
$string['addcompetency'] = 'Add competency';
$string['addcoursecompetencies'] = 'Add competencies to course';
$string['addcrossreferencedcompetency'] = 'Add cross-referenced competency';
$string['addingcompetencywillresetparentrule'] = 'Adding a new competency will remove the rule set on \'{$a}\'. Do you want to continue?';
$string['addnewcompetency'] = 'Add new competency';
$string['addnewcompetencyframework'] = 'Add new competency framework';
$string['addnewplan'] = 'Add new learning plan';
$string['addnewtemplate'] = 'Add new learning plan template';
$string['addnewuserevidence'] = 'Add new evidence';
$string['addtemplatecompetencies'] = 'Add competencies to learning plan template';
$string['aisrequired'] = '\'{$a}\' is required';
$string['aplanswerecreated'] = '{$a} learning plans were created.';
$string['aplanswerecreatedmoremayrequiresync'] = '{$a} learning plans were created; more will be created during the next synchronisation.';
$string['assigncohorts'] = 'Assign cohorts';
$string['averageproficiencyrate'] = 'The average proficiency rate for completed learning plans based on this template is {$a}%.';
$string['cancelreviewrequest'] = 'Cancel review request';
$string['cannotaddrules'] = 'This competency cannot be configured.';
$string['cannotcreateuserplanswhentemplateduedateispassed'] = 'New learning plans cannot be created. The template due date has expired, or is about to expire.';
$string['cannotcreateuserplanswhentemplatehidden'] = 'New learning plans cannot be created while this template is hidden.';
$string['category'] = 'Category';
$string['chooserating'] = 'Choose a rating...';
$string['cohortssyncedtotemplate'] = 'Cohorts synced to this learning plan template';
$string['competenciesforframework'] = 'Competencies for {$a}';
$string['competenciesmostoftennotproficient'] = 'Competencies most often not proficient in completed learning plans';
$string['competenciesmostoftennotproficientincourse'] = 'Competencies most often not proficient in this course';
$string['competencycannotbedeleted'] = 'The competency \'{$a}\' can not be deleted';
$string['competencycreated'] = 'Competency created';
$string['competencycrossreferencedcompetencies'] = '{$a} cross-referenced competencies';
$string['competencyframework'] = 'Competency framework';
$string['competencyframeworkcreated'] = 'Competency framework created.';
$string['competencyframeworkname'] = 'Name';
$string['competencyframeworkroot'] = 'No parent (top-level competency)';
$string['competencyframeworks'] = 'Competency frameworks';
$string['competencyframeworksrepository'] = 'Competency frameworks repository';
$string['competencyframeworkupdated'] = 'Competency framework updated.';
$string['competencyoutcome_complete'] = 'Mark as complete';
$string['competencyoutcome_evidence'] = 'Attach an evidence';
$string['competencyoutcome_none'] = 'None';
$string['competencyoutcome_recommend'] = 'Recommend the competency';
$string['competencypicker'] = 'Competency picker';
$string['competencyrule'] = 'Competency rule';
$string['competencyupdated'] = 'Competency updated';
$string['completeplan'] = 'Complete this learning plan';
$string['completeplanconfirm'] = 'Set the learning plan \'{$a}\' to completed? If so, the current status of all users\' competencies will be recorded, and the plan will become read only.';
$string['configurecoursecompetencysettings'] = 'Configure course competencies';
$string['configurescale'] = 'Configure scales';
$string['coursecompetencies'] = 'Course competencies';
$string['coursecompetencyratingsarenotpushedtouserplans'] = 'Competency ratings in this course do not affect learning plans.';
$string['coursecompetencyratingsarepushedtouserplans'] = 'Competency ratings in this course are updated immediately in learning plans.';
$string['coursecompetencyratingsquestion'] = 'When a course competency is rated, does the rating update the competency in the learning plans, or is it only applied to the course?';
$string['coursesusingthiscompetency'] = 'Courses linked to this competency';
$string['coveragesummary'] = '{$a->competenciescoveredcount} of {$a->competenciescount} competencies are covered ( {$a->coveragepercentage}% )';
$string['createplans'] = 'Create learning plans';
$string['createlearningplans'] = 'Create learning plans';
$string['crossreferencedcompetencies'] = 'Cross-referenced competencies';
$string['default'] = 'Default';
$string['deletecompetency'] = 'Delete competency \'{$a}\'?';
$string['deletecompetencyframework'] = 'Delete competency framework \'{$a}\'?';
$string['deletecompetencyparenthasrule'] = 'Delete competency \'{$a}\'? This will also remove the rule set for its parent.';
$string['deleteplan'] = 'Delete learning plan \'{$a}\'?';
$string['deleteplans'] = 'Delete the learning plans';
$string['deletetemplate'] = 'Delete learning plan template \'{$a}\'?';
$string['deletetemplatewithplans'] = 'This template has learning plans associated. You have to indicate how to process those plans.';
$string['deletethisplan'] = 'Delete this learning plan';
$string['deletethisuserevidence'] = 'Delete this evidence';
$string['deleteuserevidence'] = 'Delete the evidence of prior learning \'{$a}\'?';
$string['description'] = 'Description';
$string['duedate'] = 'Due date';
$string['duedate_help'] = 'The date that a learning plan should be completed by.';
$string['editcompetency'] = 'Edit competency';
$string['editcompetencyframework'] = 'Edit competency framework';
$string['editplan'] = 'Edit learning plan';
$string['editrating'] = 'Edit rating';
$string['edittemplate'] = 'Edit learning plan template';
$string['editthisplan'] = 'Edit this learning plan';
$string['editthisuserevidence'] = 'Edit this evidence';
$string['edituserevidence'] = 'Edit evidence';
$string['evidence'] = 'Evidence';
$string['findcourses'] = 'Find courses';
$string['filterbyactivity'] = 'Filter competencies by resource or activity';
$string['frameworkcannotbedeleted'] = 'The competency framework \'{$a}\' cannot be deleted';
$string['hidden'] = 'Hidden';
$string['hiddenhint'] = '(hidden)';
$string['idnumber'] = 'ID number';
$string['inheritfromframework'] = 'Inherit from competency framework (default)';
$string['itemstoadd'] = 'Items to add';
$string['jumptocompetency'] = 'Jump to competency';
$string['jumptouser'] = 'Jump to user';
$string['learningplancompetencies'] = 'Learning plan competencies';
$string['learningplans'] = 'Learning plans';
$string['levela'] = 'Level {$a}';
$string['linkcompetencies'] = 'Link competencies';
$string['linkcompetency'] = 'Link competency';
$string['linkedcompetencies'] = 'Linked competencies';
$string['linkedcourses'] = 'Linked courses';
$string['linkedcourseslist'] = 'Linked courses:';
$string['listcompetencyframeworkscaption'] = 'List of competency frameworks';
$string['listofevidence'] = 'List of evidence';
$string['listplanscaption'] = 'List of learning plans';
$string['listtemplatescaption'] = 'List of learning plan templates';
$string['loading'] = 'Loading...';
$string['locatecompetency'] = 'Locate competency';
$string['managecompetenciesandframeworks'] = 'Manage competencies and frameworks';
$string['modcompetencies'] = 'Course competencies';
$string['modcompetencies_help'] = 'Course competencies linked to this activity.';
$string['move'] = 'Move';
$string['movecompetency'] = 'Move competency';
$string['movecompetencyafter'] = 'Move competency after \'{$a}\'';
$string['movecompetencyframework'] = 'Move competency framework';
$string['movecompetencytochildofselfwillresetrules'] = 'Moving the competency will remove its own rule, and the rules set for its parent and destination. Do you want to continue?';
$string['movecompetencywillresetrules'] = 'Moving the competency will remove the rules set for its parent and destination. Do you want to continue?';
$string['moveframeworkafter'] = 'Move competency framework after \'{$a}\'';
$string['movetonewparent'] = 'Relocate';
$string['myplans'] = 'My learning plans';
$string['nfiles'] = '{$a} file(s)';
$string['noactivities'] = 'No activities';
$string['nocompetencies'] = 'No competencies have been created in this framework.';
$string['nocompetenciesincourse'] = 'No competencies have been linked to this course.';
$string['nocompetenciesinactivity'] = 'No competencies have been linked to this activity or resource.';
$string['nocompetenciesinevidence'] = 'No competencies have been linked to this evidence.';
$string['nocompetenciesinlearningplan'] = 'No competencies have been linked to this learning plan.';
$string['nocompetenciesintemplate'] = 'No competencies have been linked to this learning plan template.';
$string['nocompetenciesinlist'] = 'No competencies have been selected.';
$string['nocompetencyframeworks'] = 'No competency frameworks have been created yet.';
$string['nocompetencyselected'] = 'No competency selected';
$string['nocrossreferencedcompetencies'] = 'No other competencies have been cross-referenced to this competency.';
$string['noevidence'] = 'No evidence';
$string['nofiles'] = 'No files';
$string['nolinkedcourses'] = 'No courses are linked to this competency';
$string['noparticipants'] = 'No participants found.';
$string['noplanswerecreated'] = 'No learning plans were created.';
$string['notemplates'] = 'No learning plan templates have been created yet.';
$string['nourl'] = 'No URL';
$string['nouserevidence'] = 'No evidence of prior learning has been added yet.';
$string['nouserplans'] = 'No learning plans have been created yet.';
$string['oneplanwascreated'] = 'A learning plan was created';
$string['outcome'] = 'Outcome';
$string['overridegrade'] = 'Override existing competency grade when completed.';
$string['path'] = 'Path:';
$string['parentcompetency'] = 'Parent';
$string['parentcompetency_edit'] = 'Edit parent';
$string['parentcompetency_help'] = 'Define the parent under which the competency will be added. It can either be another competency within the same framework, or the root of the competency framework for a top-level competency.';
$string['planapprove'] = 'Make active';
$string['plancompleted'] = 'Learning plan completed';
$string['plancreated'] = 'Learning plan created';
$string['plandescription'] = 'Description';
$string['planname'] = 'Name';
$string['plantemplate'] = 'Select learning plan template';
$string['plantemplate_help'] = 'A learning plan created from a template will contain a list of competencies that match the template. Updates to the template will be reflected in any plan created from that template.';
$string['planunapprove'] = 'Send back to draft';
$string['planupdated'] = 'Learning plan updated';
$string['pluginname'] = 'Learning plans';
$string['points'] = 'Points';
$string['pointsgivenfor'] = 'Points given for \'{$a}\'';
$string['proficient'] = 'Proficient';
$string['progress'] = 'Progress';
$string['rate'] = 'Rate';
$string['ratecomment'] = 'Evidence notes';
$string['rating'] = 'Rating';
$string['ratingaffectsonlycourse'] = 'Rating a competency only updates the competency in this course';
$string['ratingaffectsuserplans'] = 'Rating a competency also updates the competency in all of the learning plans';
$string['reopenplan'] = 'Reopen this learning plan';
$string['reopenplanconfirm'] = 'Reopen the learning plan \'{$a}\'? If so, the status of the users\' competencies that was recorded at the time the plan was previously completed will be deleted, and the plan will become active again.';
$string['requestreview'] = 'Request review';
$string['reviewer'] = 'Reviewer';
$string['reviewstatus'] = 'Review status';
$string['savechanges'] = 'Save changes';
$string['scale'] = 'Scale';
$string['scale_help'] = 'A scale determines how proficiency is measured in a competency. After selecting a scale, it needs to be configured.

* The item selected as \'Default\' is the rating given when a competency is automatically completed.
* The item(s) selected as \'Proficient\' indicate(s) which value(s) will mark the competencies as proficient when they are rated.';
$string['scalevalue'] = 'Scale value';
$string['search'] = 'Search...';
$string['selectcohortstosync'] = 'Select cohorts to sync';
$string['selectcompetencymovetarget'] = 'Select a location to move this competency to:';
$string['selectedcompetency'] = 'Selected competency';
$string['selectuserstocreateplansfor'] = 'Select users to create learning plans for';
$string['sendallcompetenciestoreview'] = 'Send all competencies in review for evidence of prior learning \'{$a}\'';
$string['sendcompetenciestoreview'] = 'Send competencies for review';
$string['shortname'] = 'Name';
$string['sitedefault'] = ' (Site default) ';
$string['startreview'] = 'Start review';
$string['state'] = 'State';
$string['status'] = 'Status';
$string['stopreview'] = 'Finish review';
$string['stopsyncingcohort'] = 'Stop syncing cohort';
$string['taxonomies'] = 'Taxonomies';
$string['taxonomy_add_behaviour'] = 'Add behaviour';
$string['taxonomy_add_competency'] = 'Add competency';
$string['taxonomy_add_concept'] = 'Add concept';
$string['taxonomy_add_domain'] = 'Add domain';
$string['taxonomy_add_indicator'] = 'Add indicator';
$string['taxonomy_add_level'] = 'Add level';
$string['taxonomy_add_outcome'] = 'Add outcome';
$string['taxonomy_add_practice'] = 'Add practice';
$string['taxonomy_add_proficiency'] = 'Add proficiency';
$string['taxonomy_add_skill'] = 'Add skill';
$string['taxonomy_add_value'] = 'Add value';
$string['taxonomy_edit_behaviour'] = 'Edit behaviour';
$string['taxonomy_edit_competency'] = 'Edit competency';
$string['taxonomy_edit_concept'] = 'Edit concept';
$string['taxonomy_edit_domain'] = 'Edit domain';
$string['taxonomy_edit_indicator'] = 'Edit indicator';
$string['taxonomy_edit_level'] = 'Edit level';
$string['taxonomy_edit_outcome'] = 'Edit outcome';
$string['taxonomy_edit_practice'] = 'Edit practice';
$string['taxonomy_edit_proficiency'] = 'Edit proficiency';
$string['taxonomy_edit_skill'] = 'Edit skill';
$string['taxonomy_edit_value'] = 'Edit value';
$string['taxonomy_parent_behaviour'] = 'Parent behaviour';
$string['taxonomy_parent_competency'] = 'Parent competency';
$string['taxonomy_parent_concept'] = 'Parent concept';
$string['taxonomy_parent_domain'] = 'Parent domain';
$string['taxonomy_parent_indicator'] = 'Parent indicator';
$string['taxonomy_parent_level'] = 'Parent level';
$string['taxonomy_parent_outcome'] = 'Parent outcome';
$string['taxonomy_parent_practice'] = 'Parent practice';
$string['taxonomy_parent_proficiency'] = 'Parent proficiency';
$string['taxonomy_parent_skill'] = 'Parent skill';
$string['taxonomy_parent_value'] = 'Parent value';
$string['taxonomy_selected_behaviour'] = 'Selected behaviour';
$string['taxonomy_selected_competency'] = 'Selected competency';
$string['taxonomy_selected_concept'] = 'Selected concept';
$string['taxonomy_selected_domain'] = 'Selected domain';
$string['taxonomy_selected_indicator'] = 'Selected indicator';
$string['taxonomy_selected_level'] = 'Selected level';
$string['taxonomy_selected_outcome'] = 'Selected outcome';
$string['taxonomy_selected_practice'] = 'Selected practice';
$string['taxonomy_selected_proficiency'] = 'Selected proficiency';
$string['taxonomy_selected_skill'] = 'Selected skill';
$string['taxonomy_selected_value'] = 'Selected value';
$string['template'] = 'Learning plan template';
$string['templatebased'] = 'Template based';
$string['templatecohortnotsyncedwhileduedateispassed'] = 'Cohorts will not be synchronised if the template\'s due date has passed.';
$string['templatecohortnotsyncedwhilehidden'] = 'Cohorts will not be synchronised while this template is hidden.';
$string['templatecompetencies'] = 'Learning plan template competencies';
$string['templatecreated'] = 'Learning plan template created';
$string['templatename'] = 'Name';
$string['templates'] = 'Learning plan templates';
$string['templateupdated'] = 'Learning plan template updated';
$string['totalrequiredtocomplete'] = 'Total required to complete';
$string['unlinkcompetencycourse'] = 'Unlink the competency \'{$a}\' from the course?';
$string['unlinkcompetencyplan'] = 'Unlink the competency \'{$a}\' from the learning plan?';
$string['unlinkcompetencytemplate'] = 'Unlink the competency \'{$a}\' from the learning plan template?';
$string['unlinkplanstemplate'] = 'Unlink the learning plans from their template';
$string['unlinkplantemplate'] = 'Unlink from learning plan template';
$string['unlinkplantemplateconfirm'] = 'Unlink the learning plan \'{$a}\' from its template? Any change made to the template will no longer be applied to the plan. This action can not be undone.';
$string['uponcoursecompletion'] = 'Upon course completion:';
$string['uponcoursemodulecompletion'] = 'Upon activity completion:';
$string['usercompetencyfrozen'] = 'This record is now frozen. It reflects the state of the user\'s competency when their learning plan was marked as complete.';
$string['userevidence'] = 'Evidence of prior learning';
$string['userevidencecreated'] = 'Evidence of prior learning created';
$string['userevidencedescription'] = 'Description';
$string['userevidencefiles'] = 'Files';
$string['userevidencename'] = 'Name';
$string['userevidencesummary'] = 'Summary';
$string['userevidenceupdated'] = 'Evidence of prior learning updated';
$string['userevidenceurl'] = 'URL';
$string['userevidenceurl_help'] = 'The URL must start with \'http://\' or \'https://\'.';
$string['viewdetails'] = 'View details';
$string['visible'] = 'Visible';
$string['visible_help'] = 'A competency framework can be hidden whilst it is being set up or updated to a new version.';
$string['when'] = 'When';
$string['xcompetencieslinkedoutofy'] = '{$a->x} out of {$a->y} competencies linked to courses';
$string['xcompetenciesproficientoutofy'] = '{$a->x} out of {$a->y} competencies are proficient';
$string['xcompetenciesproficientoutofyincourse'] = 'You are proficient in {$a->x} out of {$a->y} competencies in this course.';
$string['xplanscompletedoutofy'] = '{$a->x} out of {$a->y} learning plans completed for this template';
$string['privacy:metadata'] = 'The Learning plans plugin does not store any personal data.';
