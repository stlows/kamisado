export default class Notification {
    message : string;
    variant : string;
    id : string;

    constructor(message : string, id: string, variant? : string) {
        this.message = message;
        this.id = "notification_" + Date.now();
        this.variant = typeof variant === "undefined" ? "info" : variant;
    }
}