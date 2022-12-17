import * as cheerio from 'cheerio';

const parsing = (html)=>{    
    return cheerio.load(html);
}

export default parsing;