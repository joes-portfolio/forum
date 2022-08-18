export const auth = window.App.auth;

export function can(action, authorizable) {
    return authorizable.can[action];
}
