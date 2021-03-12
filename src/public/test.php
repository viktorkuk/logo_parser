<?php

$text = 'The budget this week will be a vital test of Boris Johnson’s green credentials, with campaigners watching keenly to see whether plans match up to the government’s repeated claims to be creating a “green industrial revolution”. After this week, there are no more formal budgets to come before the UK hosts the vital UN Cop26 climate talks in Glasgow later this year. Meanwhile several of the government’s flagship green policies are in difficulties. The measures to be unveiled by Rishi Sunak, chancellor of the exchequer, include boosting cash for the national infrastructure bank, some of which will be invested in low-carbon projects, and a government-backed green savings bond for retail investors. Sunak said: “The UK is a global leader on tackling climate change, with a clear target to reach net zero by 2050, and a 10-point plan to create green jobs. We’re also launching new competitions that will unlock innovation in renewable energy, and help us develop the cutting-edge technology we need to reach net zero.” Rebecca Newsom, head of politics at Greenpeace, said many more measures were needed for a genuinely green budget that would galvanise Cop26. “The climate requires zero-carbon investment, the economy requires zero-carbon investment, and because of Cop26, diplomacy requires zero-carbon investment,” she said. “This budget is the government’s opportunity to finally show it can walk the walk, and is willing to implement change as well as call for it.” So far, the government has disappointed green experts by freezing fuel duty and axing funding for home insulation, while investing in roads and giving the go-ahead to a new coal mine. The Treasury has started to prepare for potential carbon taxes, but these are controversial, as poorly designed taxes could penalise poor people. Sam Alvis, of the thinktank Green Alliance, said: “The prime minister has called for a green recovery, but his vision hasn’t yet been backed up by the big immediate investment needed from the Treasury. There has been a lot of support for future technology, such as carbon capture and hydrogen, rather than the proven projects that will create green jobs and tackle the environmental crisis.” Johnson is under pressure from an unlikely combination of forces. His father, Stanley Johnson, international ambassador for the Conservative Environment Network, told the Times his son must “practise what he preaches” by funding nature protection. Meanwhile David Cameron, former prime minister, told the Guardian Johnson must forge a green recovery from the Covid-19 crisis. “You have to roll up your sleeves and be quite muscular in your interventionism … with active assistance and helping with key green investments that can make a difference,” he urged. Most importantly, world governments will be watching the UK carefully as they prepare their own national plans on carbon emissions, known as nationally determined contributions (NDCs) to be presented at Glasgow this November. Without stringent national plans, the Cop26 summit will fail, but an assessment by the UN published late last week showed how far off track most countries are: current NDCs, submitted by nearly half of countries under the Paris agreement, would result in only a 1% reduction in carbon by 2030, compared with the 45% cut required. Patricia Espinosa, the UN’s top climate official, said: “What we need is [countries] to put on the table much more radical, much more transformative plans than they have been doing up to now.” If the UK is to persuade other countries to come up with stronger NDCs, it must show it has plans to fulfil its own pledges. “The budget is the chancellor’s moment to show he means business ahead of the G7 and COP later this year,” said Alvis. While the demand for UK leadership has never been greater, green campaigners told the Guardian that ministers’ recent actions would need to be reversed. The government’s flagship green recovery policy, the green homes grant, has fallen into disarray, with fewer than 3,000 low-carbon measures installed after nearly six months, despite 100,000 people applying for grants. The scheme was intended to bring about 600,000 homes up to green standards. Sunak now plans to withdraw £1bn in unspent funding for this year, and to provide only £320m next year or axe the scheme altogether. Plans to bring forward a requirement for housing developers to build new homes to low-carbon standards have also been put back, to 2025. MPs have urged Sunak to at least reduce VAT on green home improvements, but even that may be denied. Housing accounts for about 40% of the UK’s emissions. Transport policy is also a concern, as the National Audit Office found last week that emissions from the sector were only 1% lower than in 2011, as SUV sales had outstripped those of electric cars. The government plans a £27bn road scheme, but has said little on boosting the charging infrastructure for electric vehicles. Last December, Johnson assured heads of state gathered for a virtual conference to mark five years of the Paris agreement that the UK would stop funding fossil fuel development overseas. However, funding for a controversial gas project is Mozambique looks set to go ahead, and other projects are still on the table. Ministers also provoked the wrath of James Hansen, the former Nasa scientist known as the godfather of climate change, as well as other prominent scientists and experts, by backing the first new deep coal mine in the UK in 30 years. The Cumbrian mine is now under review by the local council, but the cabinet’s support for it was viewed as a troubling signal. Airport expansion is also poised to be waved through by ministers, along with a potential new fleet of gas-fired power stations. Mike Childs, head of policy at Friends of the Earth, said the budget, and ministers’ decisions in the next few months, would be the acid test of the UK’s leadership on the global stage. “If the prime minister’s pledge to build back greener is to be more than just empty words, Rishi Sunak must make green jobs and infrastructure the centrepiece of this year’s budget,” he said. “Unless the government delivers on its green pledges in the near future, Boris Johnson will go into [Cop26] crucial climate talks later this year looking like the emperor with no clothes.”';

rewrite($text);

function rewrite($text)
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://rewriter-paraphraser-text-changer-multi-language.p.rapidapi.com/rewrite",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"language\":\"en\",\"strength\":3,\"text\":\"$text\"}",
        CURLOPT_HTTPHEADER => [
            "content-type: application/json",
            "x-rapidapi-host: rewriter-paraphraser-text-changer-multi-language.p.rapidapi.com",
            "x-rapidapi-key: d5e95640fbmsh321aaee82515e34p167c76jsne34976456f99"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
}
