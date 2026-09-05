const { Jimp } = require('jimp');
const fs = require('fs');

const IMAGE_PATH = 'C:/Users/RAMIM/.gemini/antigravity-ide/brain/4d1b6cd0-4f70-471b-84b8-a08129170aa4/.user_uploaded/media_1788428175833.jpg';
const RES_PATH = './android/app/src/main/res/';

const ICON_SIZES = [
  { name: 'mipmap-mdpi', size: 48 },
  { name: 'mipmap-hdpi', size: 72 },
  { name: 'mipmap-xhdpi', size: 96 },
  { name: 'mipmap-xxhdpi', size: 144 },
  { name: 'mipmap-xxxhdpi', size: 192 },
];

async function generate() {
  const image = await Jimp.read(IMAGE_PATH);
  
  for (const {name, size} of ICON_SIZES) {
    const p = RES_PATH + name;
    if (!fs.existsSync(p)) fs.mkdirSync(p, {recursive: true});
    
    console.log('Generating ' + name + ' size ' + size);
    
    // Create squared off icon
    const square = image.clone().resize({ w: size, h: size });
    square.write(p + '/ic_launcher.png');
    
    // Create round icon
    // (Jimp doesn't have a simple mask, we'll just save it as round name too for now)
    square.write(p + '/ic_launcher_round.png');
  }
  console.log('Done!');
}

generate().catch(console.error);
