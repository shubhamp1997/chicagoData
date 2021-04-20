<style>
<?php include 'homePage.css'; ?>
</style>
<html>
  <header>
    <h1>Affects of Covid-19 on Crime and Unemployment in the City of Chicago</h1>
  </header>
  <div class="form" align="center">
    <form action="diagram.php">
      <button type="submit" style="margin:5px">
        Relational Schema Diagram</button>
    </form>
  </div>
  <div class="form" align="center">
    Labor Data<br>
      <form action="complete.php">
        <button type="submit" style="margin:5px">
          Complete Labor Data</button>
      </form>
      <form action="laborDataMonthly.php">
        <button type="submit" style="margin:5px">
          Labor Data Monthly</button>
      </form>
      <form action="laborDataYearly.php">
        <button type="submit" style="margin:5px">
          Labor Data Yearly</button>
      </form>
  </div>

  <div class="form" align="center">
    Unemployment & Employment<br>
  <form action="um.php">
    <button type="submit" style="margin:5px">
      Unemployment Monthly</button>
  </form>
  <form action="uy.php">
    <button type="submit" style="margin:5px">
      Unemployment Yearly</button>
  </form>
  <form action="em.php">
    <button type="submit" style="margin:5px">
      Employment Monthly</button>
  </form>
  <form action="ey.php">
    <button type="submit" style="margin:5px">
      Employment Yearly</button>
  </form>
</div>

  <div class="form" align="center">
    Covid Data <br>
    <form action="cmy.php">
      <button type="submit" style="margin:5px">
        Covid Cases Monthly</button>
    </form>
  </div>

  <div class="form" align="center">
    Crime Data <br>
    <form action="crimeMonthly.php">
      <button type="submit" style="margin:5px">
        Crime Cases Monthly</button>
    </form>
  </div>

  <div class="form" align="center">
    Complex Queries<br>
    <form action="unemploymentDueCovid.php">
      <button type="submit" style="margin:5px">Unemployment Due to Covid</button>
    </form>
    <form action="unemploymentVScrime.php">
      <button type="submit" style="margin:5px">Unemployment VS Crime</button>
    </form>
    <form action="covidAtHome.php">
      <button type="submit" style="margin:5px">Covid Cases At Home</button>
    </form>
    <form action="covidSurviveDeath.php">
      <button type="submit" style="margin:5px">Survive VS Death Cases</button>
    </form>
  </div>

  <div class="form" align="center">
    <form action="covidAge.php">
      <button type="submit" style="margin:5px">
        Covid Filter By Age</button>
    </form>
    <form action="monthlyArrest.php">
      <button type="submit" style="margin:5px">
        Monthly Arrests In The District With Highest Crime</button>
    </form>
    <form action="apartmentVSstreet.php">
      <button type="submit" style="margin:5px">
        Apartment Arrest VS Street Arrest</button>
    </form>
  </div>

  <div class="form" align="center">
    <form action="totalVSdomestic.php">
      <button type="submit" style="margin:5px">
        Total Arrests VS Domestic Arrests</button>
    </form>
    <form action="top5crime.php">
      <button type="submit" style="margin:5px">
        Top 5 Crimes Each Year</button>
    </form>
    <form action="gun.php">
      <button type="submit" style="margin:5px">
        Gun Related Crime Cases</button>
    </form>
  </div>
</html>
