<?php
declare(strict_types = 1);

namespace Attogram\Body;

?>
<div style="margin:20px;">
    <h1>Welcome to the Body Mass Info Table</h1>
    <p>
        This table shows your
        <a href="#bmi">BMI (Body Mass Index)</a>  for a range of weights
        based on your height, age, and sex.
        Your <a href="#bmi-prime">BMI' (BMI Prime)</a> is also shown.
    </p>
    <p>
        Your BMI is used to estimate the average human body composition of
        <a href="#bfp">BFP (Body Fat Percentage)</a> versus
        <a href="#lbm">LBM (Lean Body Mass)</a>.
    </p>
    <p>
        The body composition is used to estimate caloric maintenance requirements.
        First we estimate the
        <a href="#bmr">BMR (Basal Metabolic Rate)</a>,
        and then
        <a href="#tdee">TDEE (Total Daily Energy Expenditure)</a> for various activity levels.
    </p>
    <p>
        The Body Mass Info Table is an Open Source project.  Learn more at:
        <a href="https://github.com/attogram/body-mass-info-table" target="github">
            https://github.com/attogram/body-mass-info-table</a>
    </p>

    <h2 id="howto">How to use the table</h2>
    <p>
        Enter your height (in meters), your age, and your sex.  Then click 'Update Table'.
    </p>
    <p>
        In the Table options section you can customize the weight ranges used in the table,
        and the increment between weights.
    </p>
    <a href=""><small>^top</small></a>

    <h2 id="bmi">What is BMI (Body Mass Index)?</h2>
    <p>
        The body mass index (BMI) or Quetelet index is a value derived from the mass (weight) and height
        of an individual. The BMI is defined as the body mass divided by the square of the body height,
        and is universally expressed in units of kg/m2, resulting from mass in kilograms and height in metres.
    </p>
    <p>
        The BMI is an attempt to quantify the amount of tissue mass (muscle, fat, and bone) in an individual,
        and then categorize that person as underweight, normal weight, overweight, or obese based on that value.
        That categorization is the subject of some debate about where on the BMI scale the dividing
        lines between categories should be placed.
    </p>
    <p>
        Commonly accepted BMI ranges are:
    </p>
    <ul>
        <li>underweight: under 18.5 kg/m2</li>
        <li>normal weight: 18.5 to 25</li>
        <li>overweight: 25 to 30</li>
        <li>obese: over 30</li>
    </ul>
    <p>
        BMIs under 20.0 and over 25.0 have been associated with higher all-cause mortality,
        increasing risk with distance from the 20.0-25.0 range.
        The prevalence of overweight and obesity is the highest in the Americas and lowest in South East Asia.
        The prevalence of overweight and obesity in high income and upper middle income countries is more
        than double that of low and lower middle income countries.
        <br /><small>source: https://en.wikipedia.org/wiki/Body_mass_index</small>
    </p>
    <a href=""><small>^top</small></a>

    <h2 id="bmi-prime">What is BMI' (BMI Prime)?</h2>
    <p>
        BMI Prime, a modification of the BMI system, is the ratio of actual BMI to upper limit optimal BMI
        (currently defined at 25 kg/m2), i.e., the actual BMI expressed as a proportion of upper limit optimal.
        The ratio of actual body weight to body weight for upper limit optimal BMI (25 kg/m2) is equal to
        BMI Prime. BMI Prime is a dimensionless number independent of units. Individuals with BMI Prime less
        than 0.74 are underweight; those with between 0.74 and 1.00 have optimal weight; and those at 1.00
        or greater are overweight. BMI Prime is useful clinically because it shows by what ratio (e.g. 1.36)
        or percentage (e.g. 136%, or 36% above) a person deviates from the maximum optimal BMI.
    </p>
    <p>
        For instance, a person with BMI 34 kg/m2 has a BMI Prime of 34/25 = 1.36, and is 36% over their
        upper mass limit. In South East Asian and South Chinese populations,
        BMI Prime should be calculated using an upper limit BMI of 23 in the denominator instead of 25.
        BMI Prime allows easy comparison between populations whose upper-limit optimal BMI values differ.
        <br /><small>source: https://en.wikipedia.org/wiki/Body_mass_index#BMI_Prime</small>
    </p>
    <a href=""><small>^top</small></a>

    <h2 id="bfp">What is BFP (Body Fat Percentage)?</h2>
    <p>
        The body fat percentage (BFP) of a human or other living being is
        the total mass of fat divided by total body mass, multiplied by 100; body fat includes essential
        body fat and storage body fat. Essential body fat is necessary to maintain life and reproductive
        functions. The percentage of essential body fat for women is greater than that for men, due to
        the demands of childbearing and other hormonal functions. Storage body fat consists of fat
        accumulation in adipose tissue, part of which protects internal organs in the chest and abdomen.
        The minimum recommended total body fat percentage exceeds the essential fat percentage value
        reported above. A number of methods are available for determining body fat percentage,
        such as measurement with calipers or through the use of bioelectrical impedance analysis.
    </p>
    <p>
        The body fat percentage is a measure of fitness level, since it is the only body measurement
        which directly calculates a person's relative body composition without regard to height or weight.
        The widely used body mass index (BMI) provides a measure that allows the comparison of the
        adiposity of individuals of different heights and weights. While BMI largely increases as
        adiposity increases, due to differences in body composition, other indicators of body fat
        give more accurate results; for example, individuals with greater muscle mass or larger
        bones will have higher BMIs. As such, BMI is a useful indicator of overall fitness for a
        large group of people, but a poor tool for determining the health of an individual.
        <br /><small>source: https://en.wikipedia.org/wiki/Body_fat_percentage</small>
    </p>
    <a href=""><small>^top</small></a>

    <h2 id="lbm">What is LBM (Lean Body Mass)?</h2>
    <p>
        Lean body mass (LBM) is a component of body composition, calculated by subtracting body fat
        weight from total body weight: total body weight is lean plus fat.
    </p>
    <p>
        The percentage of total body mass that is lean is usually not quoted - it would typically be 60-90%.
        Instead, the body fat percentage, which is the complement, is computed, and is typically 10-40%.
        The lean body mass (LBM) has been described as an index superior to total body weight for
        prescribing proper levels of medications and for assessing metabolic disorders, as body fat
        is less relevant for metabolism. LBW is used by anesthesiologists to dose certain medications.
        <br /><small>source: https://en.wikipedia.org/wiki/Lean_body_mass</small>
    </p>
    <a href=""><small>^top</small></a>

    <h2 id="bmr">What is BMR (Basal Metabolic Rate)?</h2>
    <p>
        Basal metabolic rate (BMR) is the rate of energy expenditure per unit time by endothermic animals at rest.
        It is reported in energy units per unit time ranging from watt (joule/second) to ml O2/min or
        joule per hour per kg body mass J/(h·kg). Proper measurement requires a strict set of criteria be met.
        These criteria include being in a physically and psychologically undisturbed state, in a thermally
        neutral environment, while in the post-absorptive state (i.e., not actively digesting food).
    </p>
    <p>
        Metabolism comprises the processes that the body needs to function.
        Basal metabolic rate is the amount of energy per unit time that a person needs to keep the
        body functioning at rest. Some of those processes are breathing, blood circulation,
        controlling body temperature, cell growth, brain and nerve function, and contraction of
        muscles. Basal metabolic rate (BMR) affects the rate that a person burns calories and
        ultimately whether that individual maintains, gains, or loses weight. The basal
        metabolic rate accounts for about 60 to 75% of the daily calorie expenditure by
        individuals. It is influenced by several factors. BMR typically declines by 1-2%
        per decade after age 20, mostly due to loss of fat-free mass, although the
        variability between individuals is high.
        <br /><small>source: https://en.wikipedia.org/wiki/Basal_metabolic_rate</small>
    </p>
    <a href=""><small>^top</small></a>

    <h2 id="tdee">What is TDEE (Total Daily Energy Expenditure)?</h2>
    <p>
        ...
    </p>
    <a href=""><small>^top</small></a>

</div>
