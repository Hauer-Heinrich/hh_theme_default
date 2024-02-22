import modal from '@typo3/backend/modal.js';
import { injectBranding } from '@{{EXTENSION_VENDOR}}/{{EXTENSION_NAMESPACE_ES6}}/author-info.js'

// modal.confirm('Warning', 'You may break the internet!', 0, [
//     {
//         text: 'Break it',
//         active: true,
//         trigger: function() {
//             // break the net
//         }
//     }, {
//         text: 'Abort!',
//         trigger: function() {
//             //console.log(injectBranding)
//             injectBranding()
//             modal.dismiss();
//         }
//     }
// ]);

injectBranding()
