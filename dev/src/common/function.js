export function I(str, type) {
    switch (type) {
        case 'i':
            console.info(str)
            break
        case 'e':
            console.error(str)
            break
        case 'w':
            console.warn(str)
            break
        default:
            console.log(str)
    }
}

