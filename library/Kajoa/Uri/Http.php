<?php
/**
 * Kajoa
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.kajoa.org/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@kajoa.org so we can send you a copy immediately.
 *
 * @category   Kajoa
 * @package    Kajoa_Uri
 * @copyright  Copyright (c) 2008-2009 Kajoa Group (http://www.kajoa.org/)
 * @version    $Id$
 */

require_once 'Zend/Uri/Http.php';

class Kajoa_Uri_Http extends Zend_Uri_Http
{
    /**
     * List of generic top-level domains
     *
     * @see http://en.wikipedia.org/wiki/List_of_Internet_top-level_domains
     * @var array
     */
    protected $_gTld = array('aero', 'asia', 'biz', 'cat', 'com', 'coop',
        'edu', 'gov', 'info', 'int', 'jobs', 'mil', 'mobi', 'museum',
        'name', 'net', 'org', 'pro', 'tel', 'travel'
    );

    /**
     * List of country code top-level domains
     *
     * @see http://en.wikipedia.org/wiki/List_of_Internet_top-level_domains
     * @var array
     */
    protected $_ccTld = array('ac', 'ad', 'ae', 'af', 'ag', 'ai', 'al',
        'am', 'an', 'ao', 'aq', 'ar', 'as', 'at', 'au', 'aw', 'ax',
        'az', 'ba', 'bb', 'bd', 'be', 'bf', 'bg', 'bh', 'bi', 'bj',
        'bm', 'bn', 'bo', 'br', 'bs', 'bt', 'bv', 'bw', 'by', 'bz',
        'ca', 'cc', 'cd', 'cf', 'cg', 'ch', 'ci', 'ck', 'cl', 'cm',
        'cn', 'co', 'cr', 'cu', 'cv', 'cx', 'cy', 'cz', 'de', 'dj',
        'dk', 'dm', 'do', 'dz', 'ec', 'ee', 'eg', 'er', 'es', 'et',
        'eu', 'fi', 'fj', 'fk', 'fm', 'fo', 'fr', 'ga', 'gb', 'gd',
        'ge', 'gf', 'gg', 'gh', 'gi', 'gl', 'gm', 'gn', 'gp', 'gq',
        'gr', 'gs', 'gt', 'gu', 'gw', 'gy', 'hk', 'hm', 'hn', 'hr',
        'ht', 'hu', 'id', 'ie', 'il', 'im', 'in', 'io', 'iq', 'ir',
        'is', 'it', 'je', 'jm', 'jo', 'jp', 'ke', 'kg', 'kh', 'ki',
        'km', 'kn', 'kp', 'kr', 'kw', 'ky', 'kz', 'la', 'lb', 'lc',
        'li', 'lk', 'lr', 'ls', 'lt', 'lu', 'lv', 'ly', 'ma', 'mc',
        'md', 'me', 'mg', 'mh', 'mk', 'ml', 'mm', 'mn', 'mo', 'mp',
        'mq', 'mr', 'ms', 'mt', 'mu', 'mv', 'mw', 'mx', 'my', 'mz',
        'na', 'nc', 'ne', 'nf', 'ng', 'ni', 'nl', 'no', 'np', 'nr',
        'nu', 'nz', 'om', 'pa', 'pe', 'pf', 'pg', 'ph', 'pk', 'pl',
        'pm', 'pn', 'pr', 'ps', 'pt', 'pw', 'py', 'qa', 're', 'ro',
        'rs', 'ru', 'rw', 'sa', 'sb', 'sc', 'sd', 'se', 'sg', 'sh',
        'si', 'sj', 'sk', 'sl', 'sm', 'sn', 'so', 'sr', 'st', 'su',
        'sv', 'sy', 'sz', 'tc', 'td', 'tf', 'tg', 'th', 'tj', 'tk',
        'tl', 'tm', 'tn', 'to', 'tp', 'tr', 'tt', 'tv', 'tw', 'tz',
        'ua', 'ug', 'uk', 'us', 'uy', 'uz', 'va', 'vc', 've', 'vg',
        'vi', 'vn', 'vu', 'wf', 'ws', 'ye', 'yt', 'yu', 'za', 'zm',
        'zw'
    );

    /**
     * List of country code second-level domain organized by top-level domain
     *
     * @see http://en.wikipedia.org/wiki/Country_code_second-level_domain
     * @see https://wiki.mozilla.org/TLD_List
     * @var array
     */
    protected $_ccSld = array(
        'ac' => array('com.ac'),
        'ad' => array('nom.ad'),
        'ae' => array('net.ae'),
        'af' => array('com.af', 'edu.af', 'gov.af', 'net.af'),
        'ag' => array('co.ag', 'com.ag', 'net.ag', 'nom.ag', 'org.ag'),
        'ai' => array('com.ai', 'net.ai', 'off.ai', 'org.ai'),
        'al' => array('com.al', 'edu.al', 'gov.al', 'net.al', 'org.al'),
        'an' => array('com.an', 'edu.an', 'net.an', 'org.an'),
        'ao' => array('co.ao', 'ed.ao', 'gv.ao', 'it.ao', 'og.ao',
                      'pb.ao'),
        'ar' => array('com.ar', 'gov.ar', 'int.ar', 'mil.ar', 'net.ar',
                      'org.ar'),
        'at' => array('ac.at', 'co.at', 'gv.at', 'or.at', 'priv.at'),
        'au' => array('act.au', 'asn.au', 'com.au', 'conf.au', 'csiro.au',
                      'id.au', 'info.au', 'net.au', 'nsw.au', 'nt.au',
                      'org.au', 'oz.au', 'qld.au', 'sa.au', 'tas.au',
                      'vic.au', 'wa.au'),
        'aw' => array('com.aw'),
        'az' => array('biz.az', 'com.az', 'edu.az', 'gov.az', 'info.az',
                      'int.az', 'mil.az', 'name.az', 'net.az', 'org.az',
                      'pp.az'),
        'bb' => array('com.bb', 'edu.bb', 'gov.bb', 'net.bb', 'org.bb'),
        'bd' => array('com.bd', 'edu.bd', 'gov.bd', 'mil.bd', 'net.bd',
                      'org.bd'),
        'be' => array('ac.be'),
        'bf' => array('gov.bf'),
        'bn' => array('com.bn', 'edu.bn', 'net.bn', 'org.bn'),
        'bo' => array('com.bo', 'edu.bo', 'gob.bo', 'gov.bo', 'int.bo',
                      'mil.bo', 'net.bo', 'org.bo', 'tv.bo'),
        'br' => array('adm.br', 'adv.br', 'agr.br', 'am.br', 'arq.br',
                      'art.br', 'ato.br', 'bio.br', 'bmd.br', 'cim.br',
                      'cng.br', 'cnt.br', 'com.br', 'coop.br', 'dpn.br',
                      'ecn.br', 'edu.br', 'eng.br', 'esp.br', 'etc.br',
                      'eti.br', 'far.br', 'fm.br', 'fnd.br', 'fot.br',
                      'fst.br', 'g12.br', 'ggf.br', 'gov.br', 'imb.br',
                      'ind.br', 'inf.br', 'jor.br', 'lel.br', 'mat.br',
                      'med.br', 'mil.br', 'mus.br', 'net.br', 'nom.br',
                      'not.br', 'ntr.br', 'odo.br', 'org.br', 'ppg.br',
                      'pro.br', 'psc.br', 'psi.br', 'qsl.br', 'rec.br',
                      'slg.br', 'srv.br', 'tmp.br', 'trd.br', 'tur.br',
                      'tv.br', 'vet.br', 'zlg.br'),
        'bs' => array('com.bs', 'edu.bs', 'gov.bs', 'net.bs', 'org.bs'),
        'bt' => array('com.bt', 'edu.bt', 'gov.bt', 'net.bt', 'org.bt'),
        'bw' => array('co.bw', 'org.bw'),
        'by' => array('gov.by', 'mil.by'),
        'ca' => array('ab.ca', 'bc.ca', 'mb.ca', 'nb.ca', 'nf.ca',
                      'nl.ca', 'ns.ca', 'nt.ca', 'nu.ca', 'on.ca',
                      'pe.ca', 'qc.ca', 'sk.ca', 'yk.ca'),
        'cc' => array('co.cc'),
        'cd' => array('com.cd', 'net.cd', 'org.cd'),
        'ch' => array('com.ch', 'gov.ch', 'net.ch', 'org.ch'),
        'ck' => array('biz.ck', 'co.ck', 'edu.ck', 'gen.ck', 'gov.ck',
                      'info.ck', 'net.ck', 'org.ck'),
        'cn' => array('ac.cn', 'ah.cn', 'bj.cn', 'cn', 'com.cn', 'cq.cn',
                      'edu.cn', 'fj.cn', 'gd.cn', 'gov.cn', 'gs.cn',
                      'gx.cn', 'gz.cn', 'ha.cn', 'hb.cn', 'he.cn',
                      'hi.cn', 'hl.cn', 'hn.cn', 'jl.cn', 'js.cn',
                      'jx.cn', 'ln.cn', 'net.cn', 'nm.cn', 'nx.cn',
                      'org.cn', 'qh.cn', 'sc.cn', 'sd.cn', 'sh.cn',
                      'sn.cn', 'sx.cn', 'tj.cn', 'xj.cn', 'xz.cn',
                      'yn.cn', 'zj.cn'),
        'co' => array('com.co', 'edu.co', 'gov.co', 'mil.co', 'net.co',
                      'nom.co', 'org.co'),
        'cr' => array('ac.cr', 'co.cr', 'ed.cr', 'fi.cr', 'go.cr',
                      'or.cr', 'sa.cr'),
        'cu' => array('com.cu', 'edu.cu', 'gov.cu', 'inf.cu', 'net.cu',
                      'org.cu'),
        'cx' => array('gov.cx'),
        'cy' => array('ac.cy', 'biz.cy', 'com.cy', 'ekloges.cy',
                      'info.cy', 'ltd.cy', 'name.cy', 'net.cy', 'org.cy',
                      'parliament.cy', 'press.cy', 'pro.cy', 'tm.cy'),
        'dm' => array('com.dm', 'edu.dm', 'gov.dm', 'net.dm', 'org.dm'),
        'do' => array('art.do', 'com.do', 'edu.do', 'gob.do', 'gov.do',
                      'mil.do', 'net.do', 'org.do', 'sld.do', 'web.do'),
        'dz' => array('art.dz', 'asso.dz', 'com.dz', 'edu.dz', 'gov.dz',
                      'net.dz', 'org.dz', 'pol.dz'),
        'ec' => array('com.ec', 'edu.ec', 'fin.ec', 'gov.ec', 'info.ec',
                      'med.ec', 'mil.ec', 'net.ec', 'org.ec', 'pro.ec'),
        'ee' => array('com.ee', 'fie.ee', 'org.ee', 'pri.ee'),
        'eg' => array('com.eg', 'edu.eg', 'eun.eg', 'gov.eg', 'mil.eg',
                      'net.eg', 'org.eg', 'sci.eg'),
        'es' => array('com.es', 'edu.es', 'gob.es', 'nom.es', 'org.es'),
        'et' => array('biz.et', 'com.et', 'edu.et', 'gov.et', 'info.et',
                      'name.et', 'net.et', 'org.et'),
        'fi' => array('aland.fi'),
        'fj' => array('ac.fj', 'biz.fj', 'com.fj', 'gov.fj', 'info.fj',
                      'mil.fj', 'name.fj', 'net.fj', 'org.fj', 'pro.fj',
                      'school.fj'),
        'fk' => array('ac.fk', 'co.fk', 'gov.fk', 'net.fk', 'nom.fk',
                      'org.fk'),
        'fr' => array('asso.fr', 'com.fr', 'gouv.fr', 'nom.fr', 'prd.fr',
                      'presse.fr', 'tm.fr'),
        'ge' => array('com.ge', 'edu.ge', 'gov.ge', 'mil.ge', 'net.ge',
                      'org.ge', 'pvt.ge'),
        'gg' => array('ac.gg', 'co.gg', 'gov.gg', 'net.gg', 'org.gg',
                      'sch.gg'),
        'gh' => array('com.gh', 'edu.gh', 'gov.gh', 'mil.gh', 'org.gh'),
        'gi' => array('com.gi', 'edu.gi', 'gov.gi', 'ltd.gi', 'mod.gi',
                      'org.gi'),
        'gn' => array('ac.gn', 'com.gn', 'gov.gn', 'net.gn', 'org.gn'),
        'gp' => array('asso.gp,', 'com.gp,', 'edu.gp,', 'net.gp,', 'or',
                      'org.gp'),
        'gr' => array('com.gr', 'edu.gr', 'gov.gr', 'net.gr', 'org.gr'),
        'hk' => array('com.hk', 'edu.hk', 'gov.hk', 'idv.hk', 'net.hk',
                      'org.hk'),
        'hn' => array('com.hn', 'edu.hn', 'gob.hn', 'mil.hn', 'net.hn',
                      'org.hn'),
        'hr' => array('com.hr', 'from.hr', 'iz.hr', 'name.hr'),
        'ht' => array('adult.ht', 'art.ht', 'asso.ht', 'com.ht',
                      'coop.ht', 'edu.ht', 'firm.ht', 'gouv.ht',
                      'info.ht', 'med.ht', 'net.ht', 'org.ht', 'perso.ht',
                      'pol.ht', 'pro.ht', 'rel.ht', 'shop.ht'),
        'hu' => array('2000.hu', 'agrar.hu', 'bolt.hu', 'casino.hu',
                      'city.hu', 'co.hu', 'erotica.hu', 'erotika.hu',
                      'film.hu', 'forum.hu', 'games.hu', 'hotel.hu',
                      'info.hu', 'ingatlan.hu', 'jogasz.hu', 'konyvelo.hu',
                      'lakas.hu', 'media.hu', 'news.hu', 'org.hu',
                      'priv.hu', 'reklam.hu', 'sex.hu', 'shop.hu',
                      'sport.hu', 'suli.hu', 'szex.hu', 'tm.hu',
                      'tozsde.hu', 'utazas.hu', 'video.hu'),
        'id' => array('ac.id', 'co.id', 'go.id', 'or.id'),
        'ie' => array('gov.ie'),
        'il' => array('ac.il', 'co.il', 'gov.il', 'idf.il', 'k12.il',
                      'muni.il', 'net.il', 'org.il'),
        'im' => array('ac.im', 'co.im', 'gov.im', 'ltd.co.im', 'net.im',
                      'nic.im', 'org.im', 'plc.co.im'),
        'in' => array('ac.in', 'co.in', 'edu.in', 'firm.in', 'gen.in',
                      'gov.in', 'ind.in', 'mil.in', 'net.in', 'nic.in',
                      'org.in', 'res.in'),
        'ir' => array('ac.ir', 'co.ir', 'gov.ir', 'net.ir', 'org.ir',
                      'sch.ir'),
        'it' => array('edu.it', 'gov.it'),
        'je' => array('co.je', 'net.je', 'org.je'),
        'jm' => array('com.jm', 'edu.jm', 'gov.jm', 'net.jm', 'org.jm'),
        'jo' => array('com.jo', 'edu.jo', 'gov.jo', 'mil.jo', 'net.jo',
                      'org.jo'),
        'jp' => array('ac.jp', 'ad.jp', 'co.jp', 'ed.jp', 'go.jp',
                      'gr.jp', 'lg.jp', 'ne.jp', 'or.jp'),
        'kh' => array('com.kh', 'edu.kh', 'gov.kh', 'mil.kh', 'net.kh',
                      'org.kh', 'per.kh'),
        'kr' => array('ac.kr,', 'busan.kr,', 'chungbuk.kr,',
                      'chungnam.kr,', 'co.kr,', 'daegu.kr,', 'daejeon.kr,',
                      'es.kr,', 'gangwon.kr,', 'go.kr,', 'gwangju.kr,',
                      'gyeongbuk.kr,', 'gyeonggi.kr,', 'gyeongnam.kr,',
                      'hs.kr,', 'incheon.kr,', 'jeju.kr', 'jeonbuk.kr,',
                      'jeonnam.kr,', 'kg.kr,', 'mil.kr,', 'ms.kr,',
                      'ne.kr,', 'or.kr,', 'pe.kr,', 're.kr,', 'sc.kr,',
                      'seoul.kr,', 'ulsan.kr,'),
        'kw' => array('com.kw', 'edu.kw', 'gov.kw', 'mil.kw', 'net.kw',
                      'org.kw'),
        'ky' => array('com.ky', 'edu.ky', 'gov.ky', 'net.ky', 'org.ky'),
        'kz' => array('com.kz', 'edu.kz', 'gov.kz', 'mil.kz', 'net.kz',
                      'org.kz'),
        'lb' => array('com.lb', 'edu.lb', 'gov.lb', 'net.lb', 'org.lb'),
        'lc' => array('com.lc', 'edu.lc', 'gov.lc', 'org.lc'),
        'li' => array('com.li', 'gov.li', 'net.li', 'org.li'),
        'lk' => array('assn.lk', 'com.lk', 'edu.lk', 'gov.lk', 'grp.lk',
                      'hotel.lk', 'int.lk', 'ltd.lk', 'net.lk', 'ngo.lk',
                      'org.lk', 'sch.lk', 'soc.lk', 'web.lk'),
        'lr' => array('com.lr', 'edu.lr', 'gov.lr', 'net.lr', 'org.lr'),
        'ls' => array('co.ls', 'org.ls'),
        'lt' => array('gov.lt', 'mil.lt'),
        'lu' => array('gov.lu', 'mil.lu', 'net.lu', 'org.lu'),
        'lv' => array('asn.lv', 'com.lv', 'conf.lv', 'edu.lv', 'gov.lv',
                      'id.lv', 'mil.lv', 'net.lv', 'org.lv'),
        'ly' => array('com.ly', 'edu.ly', 'gov.ly', 'id.ly', 'med.ly',
                      'net.ly', 'org.ly', 'plc.ly', 'sch.ly'),
        'ma' => array('ac.ma', 'co.ma', 'gov.ma', 'net.ma', 'org.ma',
                      'press.ma'),
        'mc' => array('asso.mc', 'tm.mc'),
        'mg' => array('com.mg', 'edu.mg', 'gov.mg', 'mil.mg', 'nom.mg',
                      'org.mg', 'prd.mg', 'tm.mg'),
        'mk' => array('com.mk', 'org.mk'),
        'mo' => array('com.mo', 'edu.mo', 'gov.mo', 'net.mo', 'org.mo'),
        'mt' => array('com.mt', 'edu.mt', 'gov.mt', 'net.mt', 'org.mt'),
        'mu' => array('ac.mu', 'co.mu', 'com.mu', 'gov.mu', 'net.mu',
                      'or.mu', 'org.mu'),
        'mv' => array('aero.mv', 'biz.mv', 'com.mv', 'coop.mv', 'edu.mv',
                      'gov.mv', 'info.mv', 'int.mv', 'mil.mv',
                      'museum.mv', 'name.mv', 'net.mv', 'org.mv',
                      'pro.mv'),
        'mw' => array('ac.mw', 'co.mw', 'com.mw', 'coop.mw', 'edu.mw',
                      'gov.mw', 'int.mw', 'museum.mw', 'net.mw',
                      'org.mw'),
        'mx' => array('com.mx', 'edu.mx', 'gob.mx', 'net.mx', 'org.mx'),
        'my' => array('com.my', 'edu.my', 'gov.my', 'mil.my', 'name.my',
                      'net.my', 'org.my'),
        'ng' => array('com.ng', 'edu.ng', 'gov.ng', 'net.ng', 'org.ng'),
        'ni' => array('com.ni', 'edu.ni', 'gob.ni', 'net.ni', 'nom.ni',
                      'org.ni'),
        // .nl :  Domains from .000.nl to .999.nl are personal domain names
        'no' => array('fhs.no', 'folkebibl.no', 'fylkesbibl.no',
                      'herad.no', 'idrett.no', 'kommune.no', 'mil.no',
                      'museum.no', 'priv.no', 'stat.no', 'vgs.no'),
        'np' => array('com.np', 'edu.np', 'gov.np', 'mil.np', 'net.np',
                      'org.np'),
        'nr' => array('biz.nr', 'com.nr', 'edu.nr', 'gov.nr', 'info.nr',
                      'net.nr', 'nr', 'org.nr'),
        'nz' => array('ac.nz', 'co.nz', 'cri.nz', 'geek.nz', 'gen.nz',
                      'govt.nz', 'iwi.nz', 'maori.nz', 'mil.nz', 'net.nz',
                      'org.nz', 'school.nz'),
        'om' => array('ac.com', 'biz.om', 'co.om', 'com.om', 'edu.om',
                      'gov.om', 'med.om', 'mil.om', 'museum.om', 'net.om',
                      'org.om', 'pro.om', 'sch.om'),
        'pa' => array('abo.pa', 'ac.pa', 'com.pa', 'edu.pa', 'gob.pa',
                      'ing.pa', 'med.pa', 'net.pa', 'nom.pa', 'org.pa',
                      'sld.pa'),
        'pe' => array('com.pe', 'edu.pe', 'gob.pe', 'mil.pe', 'net.pe',
                      'nom.pe', 'org.pe'),
        'pf' => array('com.pf', 'edu.pf', 'org.pf'),
        'pg' => array('com.pg', 'net.pg'),
        'ph' => array('com.ph', 'edu.ph', 'gov.ph', 'i.ph', 'mil.ph',
                      'net.ph', 'ngo.ph', 'org.ph'),
        'pk' => array('biz.pk', 'com.pk', 'edu.pk', 'fam.pk', 'gob.pk',
                      'gok.pk', 'gon.pk', 'gop.pk', 'gos.pk', 'gov.pk',
                      'net.pk', 'org.pk', 'web.pk'),
        //.pl : //https://wiki.mozilla.org/TLD_List:.pl
        'pl' => array('6bone.pl', 'agro.pl', 'aid.pl', 'art.pl', 'atm.pl',
                      'auto.pl', 'biz.pl', 'com.pl', 'edu.pl', 'gmina.pl',
                      'gov.pl', 'gsm.pl', 'info.pl', 'irc.pl', 'mail.pl',
                      'mbone.pl', 'med.pl', 'media.pl', 'miasta.pl',
                      'mil.pl', 'net.pl', 'ngo.pl', 'nieruchomosci.pl',
                      'nom.pl', 'org.pl', 'pa.gov.pl', 'pc.pl',
                      'po.gov.pl', 'powiat.pl', 'priv.pl', 'realestate.pl',
                      'rel.pl', 'sex.pl', 'shop.pl', 'sklep.pl',
                      'so.gov.pl', 'sos.pl', 'sr.gov.pl',
                      'starostwo.gov.pl', 'szkola.pl', 'targi.pl', 'tm.pl',
                      'tourism.pl', 'travel.pl', 'turystyka.pl',
                      'ug.gov.pl', 'um.gov.pl', 'upow.gov.pl', 'usenet.pl',
                      'uw.gov.pl'),
        'pr' => array('biz.pr', 'com.pr', 'edu.pr', 'gov.pr', 'info.pr',
                      'isla.pr', 'name.pr', 'net.pr', 'org.pr', 'pro.pr'),
        'pro' => array('cpa.pro', 'law.pro', 'med.pro'),
        'ps' => array('com.ps', 'edu.ps', 'gov.ps', 'net.ps', 'org.ps',
                      'plo.ps', 'sec.ps'),
        'pt' => array('com.pt', 'edu.pt', 'gov.pt', 'int.pt', 'net.pt',
                      'nome.pt', 'org.pt', 'publ.pt'),
        'py' => array('com.py', 'edu.py', 'gov.py', 'net.py', 'org.py'),
        'ro' => array('arts.ro', 'com.ro', 'firm.ro', 'info.ro', 'nom.ro',
                      'nt.ro', 'org.ro', 'rec.ro', 'store.ro', 'tm.ro',
                      'www.ro'),
        'ru' => array('ac.ru', 'com.ru', 'int.ru', 'msk.ru', 'net.ru',
                      'org.ru', 'pp.ru'),
        'rw' => array('ac.rw', 'co.rw', 'com.rw', 'edu.rw', 'gouv.rw',
                      'gov.rw', 'int.rw', 'mil.rw', 'net.rw'),
        'sa' => array('com.sa', 'edu.sa', 'gov.sa', 'med.sa', 'net.sa',
                      'org.sa', 'pub.sa', 'sch.sa'),
        'sb' => array('com.sb', 'edu.sb', 'gov.sb', 'net.sb', 'org.sb'),
        'sc' => array('com.sc', 'edu.sc', 'gov.sc', 'net.sc', 'org.sc'),
        'sd' => array('com.sd', 'edu.sd', 'gov.sd', 'info.sd', 'med.sd',
                      'net.sd', 'org.sd', 'tv.sd'),
        'se' => array('ab.se', 'ac.se', 'bd.se', 'brand.se', 'c.se',
                      'd.se', 'e.se', 'f.se', 'fh.se', 'fhsk.se',
                      'fhv.se', 'g.se', 'h.se', 'i.se', 'k.se',
                      'komforb.se', 'kommunalforbund.se', 'komvux.se',
                      'lanarb.se', 'lanbib.se', 'm.se', 'mil.se', 'n.se',
                      'naturbruksgymn.se', 'o.se', 'org.se', 'parti.se',
                      'pp.se', 'press.se', 's.se', 'sshn.se', 't.se',
                      'tm.se', 'u.se', 'w.se', 'x.se', 'y.se', 'z.se'),
        'sg' => array('com.sg', 'edu.sg', 'gov.sg', 'idn.sg', 'net.sg',
                      'org.sg', 'per.sg'),
        'sv' => array('com.sv', 'edu.sv', 'gob.sv', 'org.sv', 'red.sv'),
        'sy' => array('com.sy', 'edu.sy', 'gov.sy', 'mil.sy', 'net.sy',
                      'news.sy', 'org.sy'),
        'th' => array('ac.th', 'co.th', 'go.th', 'in.th', 'mi.th',
                      'net.th', 'or.th'),
        'tj' => array('ac.tj', 'biz.tj', 'co.tj', 'com.tj', 'edu.tj',
                      'go.tj', 'gov.tj', 'int.tj', 'mil.tj', 'name.tj',
                      'net.tj', 'org.tj', 'web.tj'),
        'tn' => array('com.tn', 'ens.tn', 'fin.tn', 'gov.tn', 'ind.tn',
                      'info.tn', 'intl.tn', 'nat.tn', 'net.tn', 'org.tn',
                      'tourism.tn'),
        'to' => array('gov.to'),
        'tp' => array('gov.tp'),
        'tr' => array('av.tr', 'bbs.tr', 'bel.tr', 'biz.tr', 'com.tr',
                      'dr.tr', 'edu.tr', 'gen.tr', 'gov.tr', 'info.tr',
                      'k12.tr', 'mil.tr', 'name.tr', 'net.tr', 'org.tr',
                      'pol.tr', 'tel.tr', 'web.tr'),
        'tt' => array('biz.tt', 'co.tt', 'com.tt', 'edu.tt', 'gov.tt',
                      'info.tt', 'name.tt', 'net.tt', 'org.tt', 'pro.tt'),
        'tv' => array('gov.tv'),
        // .tw : There are 3 additional IDN domain names : 網路.tw 組織.tw 商業.tw
        'tw' => array('club.tw', 'com.tw', 'ebiz.tw', 'edu.tw', 'game.tw',
                      'gov.tw', 'idv.tw', 'mil.tw', 'net.tw', 'org.tw'),
        'tz' => array('ac.tz', 'co.tz', 'go.tz', 'ne.tz', 'or.tz'),
        'ua' => array('cherkassy.ua', 'chernigov.ua', 'chernovtsy.ua',
                      'ck.ua', 'cn.ua', 'com.ua', 'crimea.ua', 'cv.ua',
                      'dn.ua', 'dnepropetrovsk.ua', 'donetsk.ua', 'dp.ua',
                      'edu.ua', 'gov.ua', 'if.ua', 'ivano-frankivsk.ua',
                      'kh.ua', 'kharkov.ua', 'kherson.ua',
                      'khmelnitskiy.ua', 'kiev.ua', 'kirovograd.ua',
                      'km.ua', 'kr.ua', 'ks.ua', 'kv.ua', 'lg.ua',
                      'lugansk.ua', 'lutsk.ua', 'lviv.ua', 'mk.ua',
                      'net.ua', 'nikolaev.ua', 'od.ua', 'odessa.ua',
                      'org.ua', 'pl.ua', 'poltava.ua', 'rovno.ua',
                      'rv.ua', 'sebastopol.ua', 'sumy.ua', 'te.ua',
                      'ternopil.ua', 'uzhgorod.ua', 'vinnica.ua', 'vn.ua',
                      'zaporizhzhe.ua', 'zhitomir.ua', 'zp.ua', 'zt.ua'),
        'ug' => array('ac.ug', 'co.ug', 'go.ug', 'ne.ug', 'or.ug',
                      'sc.ug'),
        'uk' => array('ac.uk', 'co.uk', 'gov.uk', 'ltd.uk', 'me.uk',
                      'mil.uk', 'mod.uk', 'net.uk', 'nhs.uk', 'nic.uk',
                      'org.uk', 'plc.uk', 'police.uk', 'sch.uk'),
        'us' => array('ak.us', 'al.us', 'ar.us', 'az.us', 'ca.us',
                      'co.us', 'ct.us', 'dc.us', 'de.us', 'dni.us',
                      'fed.us', 'fl.us', 'ga.us', 'hi.us', 'ia.us',
                      'id.us', 'il.us', 'in.us', 'isa.us', 'kids.us',
                      'ks.us', 'ky.us', 'la.us', 'ma.us', 'md.us',
                      'me.us', 'mi.us', 'mn.us', 'mo.us', 'ms.us',
                      'mt.us', 'nc.us', 'nd.us', 'ne.us', 'nh.us',
                      'nj.us', 'nm.us', 'nsn.us', 'nv.us', 'ny.us',
                      'oh.us', 'ok.us', 'or.us', 'pa.us', 'ri.us',
                      'sc.us', 'sd.us', 'tn.us', 'tx.us', 'ut.us',
                      'va.us', 'vt.us', 'wa.us', 'wi.us', 'wv.us',
                      'wy.us'),
        'uy' => array('com.uy', 'edu.uy', 'gub.uy', 'mil.uy', 'net.uy',
                      'org.uy'),
        'va' => array('vatican.va'),
        've' => array('co.ve', 'com.ve', 'info.ve', 'net.ve', 'org.ve',
                      'web.ve'),
        'vi' => array('com.vi', 'edu.vi', 'gov.vi', 'org.vi'),
        'vn' => array('ac.vn', 'biz.vn', 'com.vn', 'edu.vn', 'gov.vn',
                      'health.vn', 'info.vn', 'int.vn', 'name.vn',
                      'net.vn', 'org.vn', 'pro.vn'),
        'ye' => array('co.ye', 'com.ye', 'gov.ye', 'ltd.ye',
                      'me.yenet.ye', 'org.ye', 'plc.ye'),
        'yu' => array('ac.yu', 'co.yu', 'edu.yu', 'org.yu'),
        'za' => array('ac.za', 'alt.za', 'city.za', 'co.za', 'edu.za',
                      'gov.za', 'law.za', 'mil.za', 'net.za', 'ngo.za',
                      'nom.za', 'org.za', 'school.za', 'tm.za', 'web.za'),
        'zm' => array('ac.zm', 'co.zm', 'gov.zm', 'org.zm', 'sch.zm'),
        'zw' => array('ac.zw', 'co.zw', 'gov.zw', 'org.zw'),
    );

    /**
     * List of infrastructure top-level domains
     *
     * @see http://en.wikipedia.org/wiki/List_of_Internet_top-level_domains
     * @var array
     */
    protected $_iTld = array('arpa');

    /**
     * Creates a Zend_Uri_Http from the given string
     *
     * @param  string $uri String to create URI from, must start with
     *                     'http://' or 'https://'
     * @throws InvalidArgumentException  When the given $uri is not a string or
     *                                   does not start with http:// or https://
     * @throws Zend_Uri_Exception        When the given $uri is invalid
     * @return Zend_Uri_Http
     */
    public static function fromString($uri)
    {
        if (is_string($uri) === false) {
            throw new InvalidArgumentException('$uri is not a string');
        }

        $uri            = explode(':', $uri, 2);
        $scheme         = strtolower($uri[0]);
        $schemeSpecific = isset($uri[1]) === true ? $uri[1] : '';

        if (in_array($scheme, array('http', 'https')) === false) {
            require_once 'Zend/Uri/Exception.php';
            throw new Kajoa_Uri_Exception("Invalid scheme: '$scheme'");
        }

        $schemeHandler = new Kajoa_Uri_Http($scheme, $schemeSpecific);
        return $schemeHandler;
    }

    public function getDomainName($restrictToSecondLevelDomain = false)
    {
        if (!$this->valid()) {
            throw new Kajoa_Uri_Domain_Exception("Invalid URI '$this->_uri'");
        }

        $secondLevelDomain = $this->getSecondLevelDomain();

        if (!$restrictToSecondLevelDomain && $this->isCountryCodeSld() &&
            $this->hasThirdLevelDomain()) {
            return $this->getThirdLevelDomain();
        }

        return $secondLevelDomain;
    }

    public function getCountryCodeSldList()
    {
        return $this->_ccSld;
    }

    public function getCountryCodeTldList()
    {
        return $this->_ccTld;
    }

    public function getGenericTldList()
    {
        return $this->_gTld;
    }

    public function getInfrastructureTldList()
    {
        return $this->_iTld;
    }

    public function getSecondLevelDomain()
    {
        return $this->getSpecificLevelDomain(2);
    }

    public function getSpecificLevelDomain($level)
    {
        $levels = explode('.', $this->getHost());
        $count  = count($levels);

        if ($level > $count) {
            throw new Kajoa_Uri_Http_Exception('Invalid level');
        }

        $result = array();
        for ($i = $count -1; $i >= $count - $level; $i--) {
            $result[] = $levels[$i];
        }
        $result = array_reverse($result);

        return implode('.', $result);
    }

    public function getThirdLevelDomain()
    {
        return $this->getSpecificLevelDomain(3);
    }

    public function getTldList()
    {
        return array_merge($this->_gTld, $this->_ccTld, $this->_iTld);
    }

    public function getTopLevelDomain()
    {
        return $this->getSpecificLevelDomain(1);
    }

    public function hasSpecificLevelDomain($level)
    {
        $levels = explode('.', $this->getHost());
        return $level <= count($levels);
    }

    public function hasThirdLevelDomain()
    {
        return $this->hasSpecificLevelDomain(3);
    }

    public function isCountryCodeSld()
    {
        $tld = $this->getTopLevelDomain();
        if (!array_key_exists($tld, $this->_ccSld)) {
            return false;
        }

        $sld = $this->getSecondLevelDomain();
        return in_array($sld, $this->_ccSld[$tld]);
    }

    public function validateHost($host = null)
    {
        if ($host === null) {
            $host = $this->_host;
        }

        // If the host is empty, then it is considered invalid
        if (strlen($host) === 0) {
            return false;
        }

        // Check the host against the allowed values; delegated to Zend_Filter.
        $validate = new Zend_Validate_Hostname(Zend_Validate_Hostname::ALLOW_DNS);

        return $validate->isValid($host);
    }

    public function validateSecondLevelDomain($sld = null)
    {
        if (null === $sld) {
            $sld = $this->getSecondLevelDomain();
        }

        return in_array($sld, $this->getTldList());
    }

    public function validateTopLevelDomain($tld = null)
    {
        if (null === $tld) {
            $tld = $this->getTopLevelDomain();
        }

        return in_array($tld, $this->getTldList());
    }
}