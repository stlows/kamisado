export default class Settings {
  playType: PlayType;
  rival: Rival;
  pointsToWin: Number;

  constructor(playType: PlayType, rival: Rival, pointsToWin: Number) {
    this.playType = playType;
    this.rival = rival;
    this.pointsToWin = pointsToWin;
  }
}
enum PlayType {
  Local,
  Online
}

enum Rival {
  Ai,
  Human
}
