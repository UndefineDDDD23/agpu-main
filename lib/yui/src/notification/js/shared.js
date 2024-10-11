/* eslint-disable no-unused-vars, no-unused-expressions */
var DIALOGUE_PREFIX,
    BASE,
    CONFIRMYES,
    CONFIRMNO,
    TITLE,
    QUESTION,
    CSS_CLASSES;

DIALOGUE_PREFIX = 'agpu-dialogue';
BASE = 'notificationBase';
CONFIRMYES = 'yesLabel';
CONFIRMNO = 'noLabel';
TITLE = 'title';
QUESTION = 'question';
CSS_CLASSES = {
    BASE: 'agpu-dialogue-base',
    WRAP: 'agpu-dialogue-wrap',
    HEADER: 'agpu-dialogue-hd',
    BODY: 'agpu-dialogue-bd',
    CONTENT: 'agpu-dialogue-content',
    FOOTER: 'agpu-dialogue-ft',
    HIDDEN: 'hidden',
    LIGHTBOX: 'agpu-dialogue-lightbox'
};

// Set up the namespace once.
M.core = M.core || {};
