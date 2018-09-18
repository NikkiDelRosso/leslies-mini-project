<template>
    <div>
        <nav class="navbar navbar-dark">
            <div class="container">
                <router-link class="navbar-brand" to="/">Awesome Pool Supplier</router-link>
                <span class="navbar-text">
                    Selling sweet pool supplies... with no actual way to buy them!
                </span>
            </div>
        </nav>
        <main role="main">
            <router-view></router-view>
        </main>
        <footer class="text-light bg-dark mt-5">
            <div class="container">
                <div class="pb-5 pt-4">
                    <p class="float-right">
                        <a href="#" class="btn btn-light">Back to top</a>
                    </p>
                    <p>A sample project by Nikki DelRosso.</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
    export default {}
</script>
