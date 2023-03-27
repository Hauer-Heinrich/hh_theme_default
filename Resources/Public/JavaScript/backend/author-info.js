/*
 * Werbeagentur Hauer-Heinrich GmbH
 *  E-Mail: info@hauer-heinrich.de
 * Website: http://www.hauer-heinrich.de
 */

export const injectBranding = () => {
    const topbarHeader = document.querySelector(".topbar-header-site")
    const brandingElement = document.createElement("span")

    brandingElement.setAttribute("id", "branding")
    brandingElement.innerHTML = "<span>designed and created by</span><a href='http://www.hauer-heinrich.de' title='Zeige mehr von Hauer-Heinrich' target='_blank'>Werbeagentur Hauer-Heinrich</a>"
    topbarHeader.append(brandingElement)
}

export default {
    injectBranding
    //anotherMethod1,
    //anotherMethod2,
}
